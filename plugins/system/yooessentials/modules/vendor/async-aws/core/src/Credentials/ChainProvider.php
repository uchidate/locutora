<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface;
/**
 * Chains several CredentialProvider together.
 *
 * Credentials are fetched from the first CredentialProvider that does not returns null.
 * The CredentialProvider will be memoized and will be directly called the next times.
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
final class ChainProvider implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider, \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface
{
    private $providers;
    /**
     * @var (CredentialProvider|null)[]
     */
    private $lastSuccessfulProvider = [];
    /**
     * @param CredentialProvider[] $providers
     */
    public function __construct(iterable $providers)
    {
        $this->providers = $providers;
    }
    public function getCredentials(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Configuration $configuration) : ?\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials
    {
        $key = \spl_object_hash($configuration);
        if (\array_key_exists($key, $this->lastSuccessfulProvider)) {
            if (null === ($provider = $this->lastSuccessfulProvider[$key])) {
                return null;
            }
            return $provider->getCredentials($configuration);
        }
        foreach ($this->providers as $provider) {
            if (null !== ($credentials = $provider->getCredentials($configuration))) {
                $this->lastSuccessfulProvider[$key] = $provider;
                return $credentials;
            }
        }
        $this->lastSuccessfulProvider[$key] = null;
        return null;
    }
    public function reset()
    {
        $this->lastSuccessfulProvider = [];
    }
    public static function createDefaultChain(?\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $httpClient = null, ?\ZOOlanders\YOOessentials\Vendor\Psr\Log\LoggerInterface $logger = null) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\CredentialProvider
    {
        $httpClient = $httpClient ?? \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient::create();
        $logger = $logger ?? new \ZOOlanders\YOOessentials\Vendor\Psr\Log\NullLogger();
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\ChainProvider([new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\ConfigurationProvider(), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\WebIdentityProvider($logger, null, $httpClient), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\IniFileProvider($logger, null, $httpClient), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\ContainerProvider($httpClient, $logger), new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\InstanceProvider($httpClient, $logger)]);
    }
}
