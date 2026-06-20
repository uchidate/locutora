<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\JsonException;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
/**
 * Provides Credentials from the running EC2 metadata server using the IMDS version 1.
 *
 * @see https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/instancedata-data-retrieval.html
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
final class InstanceProvider implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider
{
    private const ENDPOINT = 'http://169.254.169.254/latest/meta-data/iam/security-credentials';
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
        try {
            // Fetch current Profile
            $response = $this->httpClient->request('GET', self::ENDPOINT, ['timeout' => $this->timeout]);
            $profile = $response->getContent();
            // Fetch credentials from profile
            $response = $this->httpClient->request('GET', self::ENDPOINT . '/' . $profile, ['timeout' => $this->timeout]);
            $result = $this->toArray($response);
            if ('Success' !== $result['Code']) {
                $this->logger->info('Unexpected instance profile.', ['response_code' => $result['Code']]);
                return null;
            }
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
    /**
     * Copy of Symfony\Component\HttpClient\Response::toArray without assertion on Content-Type header.
     */
    private function toArray(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface $response) : array
    {
        if ('' === ($content = $response->getContent(\true))) {
            throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException('Response body is empty.');
        }
        try {
            $content = \json_decode($content, \true, 512, \JSON_BIGINT_AS_STRING | (\PHP_VERSION_ID >= 70300 ? \JSON_THROW_ON_ERROR : 0));
        } catch (\JsonException $e) {
            /** @psalm-suppress all */
            throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\JsonException(\sprintf('%s for "%s".', $e->getMessage(), $response->getInfo('url')), $e->getCode());
        }
        if (\PHP_VERSION_ID < 70300 && \JSON_ERROR_NONE !== \json_last_error()) {
            /** @psalm-suppress InvalidArgument */
            throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\JsonException(\sprintf('%s for "%s".', \json_last_error_msg(), $response->getInfo('url')), \json_last_error());
        }
        if (!\is_array($content)) {
            /** @psalm-suppress InvalidArgument */
            throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\JsonException(\sprintf('JSON content was expected to decode to an array, %s returned for "%s".', \gettype($content), $response->getInfo('url')));
        }
        return $content;
    }
}
