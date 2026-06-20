<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
/**
 * Provides Credentials from the running ECS.
 *
 * @see https://docs.aws.amazon.com/AWSJavaSDK/latest/javadoc/index.html?com/amazonaws/auth/ContainerCredentialsProvider.html
 */
final class ContainerProvider implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider
{
    private const ENDPOINT = 'http://169.254.170.2';
    private $logger;
    private $httpClient;
    private $timeout;
    public function __construct(?\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $httpClient = null, ?\ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface $logger = null, float $timeout = 1.0)
    {
        $this->logger = $logger ?? new \ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger();
        $this->httpClient = $httpClient ?? \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient::create();
        $this->timeout = $timeout;
    }
    public function getCredentials(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration $configuration) : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials
    {
        $relativeUri = $configuration->get(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration::OPTION_CONTAINER_CREDENTIALS_RELATIVE_URI);
        // introduces an early exit if the env variable is not set.
        if (empty($relativeUri)) {
            return null;
        }
        // fetch credentials from ecs endpoint
        try {
            $response = $this->httpClient->request('GET', self::ENDPOINT . $relativeUri, ['timeout' => $this->timeout]);
            $result = $response->toArray();
        } catch (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface $e) {
            $this->logger->info('Failed to decode Credentials.', ['exception' => $e]);
            return null;
        } catch (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface|\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface $e) {
            $this->logger->info('Failed to fetch Profile from Instance Metadata.', ['exception' => $e]);
            return null;
        }
        if (null !== ($date = $response->getHeaders(\false)['date'][0] ?? null)) {
            $date = new \DateTimeImmutable($date);
        }
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials($result['AccessKeyId'], $result['SecretAccessKey'], $result['Token'], \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials::adjustExpireDate(new \DateTimeImmutable($result['Expiration']), $date));
    }
}
