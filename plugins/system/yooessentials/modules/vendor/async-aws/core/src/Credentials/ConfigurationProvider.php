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
 * Provides Credentials from Configuration data.
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
final class ConfigurationProvider implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider
{
    use DateFromResult;
    private $logger;
    private $httpClient;
    public function __construct(?\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $httpClient = null, ?\ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface $logger = null)
    {
        $this->logger = $logger ?? new \ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger();
        $this->httpClient = $httpClient;
    }
    public function getCredentials(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration $configuration) : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials
    {
        $accessKeyId = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_ACCESS_KEY_ID);
        $secretAccessKeyId = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_SECRET_ACCESS_KEY);
        if (null === $accessKeyId || null === $secretAccessKeyId) {
            return null;
        }
        $credentials = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials($accessKeyId, $secretAccessKeyId, $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_SESSION_TOKEN));
        $roleArn = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_ROLE_ARN);
        if (null !== $roleArn) {
            $region = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_REGION);
            $roleSessionName = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_ROLE_SESSION_NAME);
            return $this->getCredentialsFromRole($credentials, $region, $roleArn, $roleSessionName);
        }
        /** @psalm-suppress PossiblyNullArgument */
        return $credentials;
    }
    private function getCredentialsFromRole(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials $credentials, string $region, string $roleArn, string $roleSessionName = null) : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials
    {
        $roleSessionName = $roleSessionName ?? \uniqid('async-aws-', \true);
        $stsClient = new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\StsClient(['region' => $region], $credentials, $this->httpClient);
        $result = $stsClient->assumeRole(['RoleArn' => $roleArn, 'RoleSessionName' => $roleSessionName]);
        try {
            if (null === ($credentials = $result->getCredentials())) {
                throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\RuntimeException('The AsumeRole response does not contains credentials');
            }
        } catch (\Exception $e) {
            $this->logger->warning('Failed to get credentials from assumed role: {exception}".', ['exception' => $e]);
            return null;
        }
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials($credentials->getAccessKeyId(), $credentials->getSecretAccessKey(), $credentials->getSessionToken(), \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials::adjustExpireDate($credentials->getExpiration(), $this->getDateFromResult($result)));
    }
}
