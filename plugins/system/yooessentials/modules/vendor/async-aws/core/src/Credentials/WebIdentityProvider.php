<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\RuntimeException;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\StsClient;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
/**
 * Provides Credentials from Web Identity or OpenID Connect Federation.
 *
 * @see https://docs.aws.amazon.com/IAM/latest/UserGuide/id_roles_create_for-idp_oidc.html
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
final class WebIdentityProvider implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider
{
    use DateFromResult;
    private $iniFileLoader;
    private $logger;
    private $httpClient;
    public function __construct(?\ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface $logger = null, ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader $iniFileLoader = null, ?\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $httpClient = null)
    {
        $this->logger = $logger ?? new \ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger();
        $this->iniFileLoader = $iniFileLoader ?? new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader($this->logger);
        $this->httpClient = $httpClient;
    }
    public function getCredentials(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration $configuration) : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials
    {
        $roleArn = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_ROLE_ARN);
        $tokenFile = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_WEB_IDENTITY_TOKEN_FILE);
        if ($tokenFile && $roleArn) {
            return $this->getCredentialsFromRole($roleArn, $tokenFile, $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_ROLE_SESSION_NAME), $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_REGION));
        }
        $profilesData = $this->iniFileLoader->loadProfiles([$configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_SHARED_CREDENTIALS_FILE), $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_SHARED_CONFIG_FILE)]);
        if (empty($profilesData)) {
            return null;
        }
        /** @var string $profile */
        $profile = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_PROFILE);
        if (!isset($profilesData[$profile])) {
            $this->logger->warning('Profile "{profile}" not found.', ['profile' => $profile]);
            return null;
        }
        $profileData = $profilesData[$profile];
        $roleArn = $profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_ROLE_ARN] ?? null;
        $tokenFile = $profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_WEB_IDENTITY_TOKEN_FILE] ?? null;
        if (null !== $roleArn && null !== $tokenFile) {
            return $this->getCredentialsFromRole($roleArn, $tokenFile, $profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_ROLE_SESSION_NAME] ?? null, $profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_REGION] ?? $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_REGION));
        }
        return null;
    }
    private function getCredentialsFromRole(string $roleArn, string $tokenFile, ?string $sessionName, ?string $region) : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials
    {
        $sessionName = $sessionName ?? \uniqid('async-aws-', \true);
        if (!\preg_match("/^\\w\\:|^\\/|^\\\\/", $tokenFile)) {
            $this->logger->warning('WebIdentityTokenFile "{tokenFile}" must be an absolute path.', ['tokenFile' => $tokenFile]);
        }
        try {
            $token = $this->getTokenFileContent($tokenFile);
        } catch (\Exception $e) {
            $this->logger->warning('"Error reading WebIdentityTokenFile "{tokenFile}.', ['tokenFile' => $tokenFile, 'exception' => $e]);
            return null;
        }
        $stsClient = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\StsClient(['region' => $region], new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\NullProvider(), $this->httpClient);
        $result = $stsClient->assumeRoleWithWebIdentity(['RoleArn' => $roleArn, 'RoleSessionName' => $sessionName, 'WebIdentityToken' => $token]);
        try {
            if (null === ($credentials = $result->getCredentials())) {
                throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\RuntimeException('The AssumeRoleWithWebIdentity response does not contains credentials');
            }
        } catch (\Exception $e) {
            $this->logger->warning('Failed to get credentials from assumed role: {exception}".', ['exception' => $e]);
            return null;
        }
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials($credentials->getAccessKeyId(), $credentials->getSecretAccessKey(), $credentials->getSessionToken(), \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials::adjustExpireDate($credentials->getExpiration(), $this->getDateFromResult($result)));
    }
    /**
     * @see https://github.com/async-aws/aws/issues/900
     * @see https://github.com/aws/aws-sdk-php/issues/2014
     * @see https://github.com/aws/aws-sdk-php/pull/2043
     */
    private function getTokenFileContent(string $tokenFile) : string
    {
        $token = @\file_get_contents($tokenFile);
        if (\false !== $token) {
            return $token;
        }
        $tokenDir = \dirname($tokenFile);
        $tokenLink = \readlink($tokenFile);
        \clearstatcache(\true, $tokenDir . \DIRECTORY_SEPARATOR . $tokenLink);
        \clearstatcache(\true, $tokenDir . \DIRECTORY_SEPARATOR . \dirname($tokenLink));
        \clearstatcache(\true, $tokenFile);
        if (\false === ($token = \file_get_contents($tokenFile))) {
            throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\RuntimeException('Failed to read data');
        }
        return $token;
    }
}
