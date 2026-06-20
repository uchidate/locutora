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
 * Provides Credentials from standard AWS ini file.
 *
 * @see https://docs.aws.amazon.com/cli/latest/userguide/cli-configure-files.html
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
final class IniFileProvider implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider
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
        $profilesData = $this->iniFileLoader->loadProfiles([$configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_SHARED_CREDENTIALS_FILE), $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_SHARED_CONFIG_FILE)]);
        if (empty($profilesData)) {
            return null;
        }
        /** @var string $profile */
        $profile = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_PROFILE);
        return $this->getCredentialsFromProfile($profilesData, $profile);
    }
    private function getCredentialsFromProfile(array $profilesData, string $profile, array $circularCollector = []) : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials
    {
        if (isset($circularCollector[$profile])) {
            $this->logger->warning('Circular reference detected when loading "{profile}". Already loaded {previous_profiles}', ['profile' => $profile, 'previous_profiles' => \array_keys($circularCollector)]);
            return null;
        }
        $circularCollector[$profile] = \true;
        if (!isset($profilesData[$profile])) {
            $this->logger->warning('Profile "{profile}" not found.', ['profile' => $profile]);
            return null;
        }
        $profileData = $profilesData[$profile];
        if (isset($profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_ACCESS_KEY_ID], $profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_SECRET_ACCESS_KEY])) {
            return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials($profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_ACCESS_KEY_ID], $profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_SECRET_ACCESS_KEY], $profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_SESSION_TOKEN] ?? null);
        }
        if (isset($profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_ROLE_ARN])) {
            return $this->getCredentialsFromRole($profilesData, $profileData, $profile, $circularCollector);
        }
        $this->logger->info('No credentials found for profile "{profile}".', ['profile' => $profile]);
        return null;
    }
    private function getCredentialsFromRole(array $profilesData, array $profileData, string $profile, array $circularCollector = []) : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials
    {
        $roleArn = (string) ($profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_ROLE_ARN] ?? '');
        $roleSessionName = (string) ($profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_ROLE_SESSION_NAME] ?? \uniqid('async-aws-', \true));
        if (null === ($sourceProfileName = $profileData[\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_SOURCE_PROFILE] ?? null)) {
            $this->logger->warning('The source profile is not defined in Role "{profile}".', ['profile' => $profile]);
            return null;
        }
        /** @var string $sourceProfileName */
        $sourceCredentials = $this->getCredentialsFromProfile($profilesData, $sourceProfileName, $circularCollector);
        if (null === $sourceCredentials) {
            $this->logger->warning('The source profile "{profile}" does not contains valid credentials.', ['profile' => $profile]);
            return null;
        }
        $stsClient = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\StsClient(isset($profilesData[$sourceProfileName][\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_REGION]) ? ['region' => $profilesData[$sourceProfileName][\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileLoader::KEY_REGION]] : [], $sourceCredentials, $this->httpClient);
        $result = $stsClient->assumeRole(['RoleArn' => $roleArn, 'RoleSessionName' => $roleSessionName]);
        try {
            if (null === ($credentials = $result->getCredentials())) {
                throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\RuntimeException('The AsumeRole response does not contains credentials');
            }
        } catch (\Exception $e) {
            $this->logger->warning('Failed to get credentials from assumed role in profile "{profile}: {exception}".', ['profile' => $profile, 'exception' => $e]);
            return null;
        }
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials($credentials->getAccessKeyId(), $credentials->getSecretAccessKey(), $credentials->getSessionToken(), \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials::adjustExpireDate($credentials->getExpiration(), $this->getDateFromResult($result)));
    }
}
