<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient;

use ZOOlanders\YOOessentials\Vendor\Http\Discovery\Exception\NotFoundException;
use ZOOlanders\YOOessentials\Vendor\Http\Discovery\Psr17FactoryDiscovery;
use ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Factory\Psr17Factory;
use ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Request;
use ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Uri;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Client\ClientInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Client\NetworkExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Client\RequestExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ResponseFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ResponseInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\StreamableInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\StreamWrapper;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface;
if (!\interface_exists(\ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestFactoryInterface::class)) {
    throw new \LogicException('You cannot use the "Symfony\\Component\\HttpClient\\Psr18Client" as the "psr/http-factory" package is not installed. Try running "composer require nyholm/psr7".');
}
if (!\interface_exists(\ZOOlanders\YOOessentials\Vendor\Psr\Http\Client\ClientInterface::class)) {
    throw new \LogicException('You cannot use the "Symfony\\Component\\HttpClient\\Psr18Client" as the "psr/http-client" package is not installed. Try running "composer require psr/http-client".');
}
/**
 * An adapter to turn a Symfony HttpClientInterface into a PSR-18 ClientInterface.
 *
 * Run "composer require psr/http-client" to install the base ClientInterface. Run
 * "composer require nyholm/psr7" to install an efficient implementation of response
 * and stream factories with flex-provided autowiring aliases.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
final class Psr18Client implements \ZOOlanders\YOOessentials\Vendor\Psr\Http\Client\ClientInterface, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestFactoryInterface, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamFactoryInterface, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriFactoryInterface, \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface
{
    private $client;
    private $responseFactory;
    private $streamFactory;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $client = null, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ResponseFactoryInterface $responseFactory = null, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamFactoryInterface $streamFactory = null)
    {
        $this->client = $client ?? \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient::create();
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory ?? ($responseFactory instanceof \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamFactoryInterface ? $responseFactory : null);
        if (null !== $this->responseFactory && null !== $this->streamFactory) {
            return;
        }
        if (!\class_exists(\ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Factory\Psr17Factory::class) && !\class_exists(\ZOOlanders\YOOessentials\Vendor\Http\Discovery\Psr17FactoryDiscovery::class)) {
            throw new \LogicException('You cannot use the "Symfony\\Component\\HttpClient\\Psr18Client" as no PSR-17 factories have been provided. Try running "composer require nyholm/psr7".');
        }
        try {
            $psr17Factory = \class_exists(\ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Factory\Psr17Factory::class, \false) ? new \ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Factory\Psr17Factory() : null;
            $this->responseFactory = $this->responseFactory ?? $psr17Factory ?? \ZOOlanders\YOOessentials\Vendor\Http\Discovery\Psr17FactoryDiscovery::findResponseFactory();
            $this->streamFactory = $this->streamFactory ?? $psr17Factory ?? \ZOOlanders\YOOessentials\Vendor\Http\Discovery\Psr17FactoryDiscovery::findStreamFactory();
        } catch (\ZOOlanders\YOOessentials\Vendor\Http\Discovery\Exception\NotFoundException $e) {
            throw new \LogicException('You cannot use the "Symfony\\Component\\HttpClient\\HttplugClient" as no PSR-17 factories have been found. Try running "composer require nyholm/psr7".', 0, $e);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function sendRequest(\ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface $request) : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ResponseInterface
    {
        try {
            $body = $request->getBody();
            if ($body->isSeekable()) {
                $body->seek(0);
            }
            $response = $this->client->request($request->getMethod(), (string) $request->getUri(), ['headers' => $request->getHeaders(), 'body' => $body->getContents(), 'http_version' => '1.0' === $request->getProtocolVersion() ? '1.0' : null]);
            $psrResponse = $this->responseFactory->createResponse($response->getStatusCode());
            foreach ($response->getHeaders(\false) as $name => $values) {
                foreach ($values as $value) {
                    try {
                        $psrResponse = $psrResponse->withAddedHeader($name, $value);
                    } catch (\InvalidArgumentException $e) {
                        // ignore invalid header
                    }
                }
            }
            $body = $response instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\StreamableInterface ? $response->toStream(\false) : \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\StreamWrapper::createResource($response, $this->client);
            $body = $this->streamFactory->createStreamFromResource($body);
            if ($body->isSeekable()) {
                $body->seek(0);
            }
            return $psrResponse->withBody($body);
        } catch (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface $e) {
            if ($e instanceof \InvalidArgumentException) {
                throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Psr18RequestException($e, $request);
            }
            throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Psr18NetworkException($e, $request);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function createRequest(string $method, $uri) : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface
    {
        if ($this->responseFactory instanceof \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestFactoryInterface) {
            return $this->responseFactory->createRequest($method, $uri);
        }
        if (\class_exists(\ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Request::class)) {
            return new \ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Request($method, $uri);
        }
        if (\class_exists(\ZOOlanders\YOOessentials\Vendor\Http\Discovery\Psr17FactoryDiscovery::class)) {
            return \ZOOlanders\YOOessentials\Vendor\Http\Discovery\Psr17FactoryDiscovery::findRequestFactory()->createRequest($method, $uri);
        }
        throw new \LogicException(\sprintf('You cannot use "%s()" as the "nyholm/psr7" package is not installed. Try running "composer require nyholm/psr7".', __METHOD__));
    }
    /**
     * {@inheritdoc}
     */
    public function createStream(string $content = '') : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface
    {
        $stream = $this->streamFactory->createStream($content);
        if ($stream->isSeekable()) {
            $stream->seek(0);
        }
        return $stream;
    }
    /**
     * {@inheritdoc}
     */
    public function createStreamFromFile(string $filename, string $mode = 'r') : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface
    {
        return $this->streamFactory->createStreamFromFile($filename, $mode);
    }
    /**
     * {@inheritdoc}
     */
    public function createStreamFromResource($resource) : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface
    {
        return $this->streamFactory->createStreamFromResource($resource);
    }
    /**
     * {@inheritdoc}
     */
    public function createUri(string $uri = '') : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriInterface
    {
        if ($this->responseFactory instanceof \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriFactoryInterface) {
            return $this->responseFactory->createUri($uri);
        }
        if (\class_exists(\ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Uri::class)) {
            return new \ZOOlanders\YOOessentials\Vendor\Nyholm\Psr7\Uri($uri);
        }
        if (\class_exists(\ZOOlanders\YOOessentials\Vendor\Http\Discovery\Psr17FactoryDiscovery::class)) {
            return \ZOOlanders\YOOessentials\Vendor\Http\Discovery\Psr17FactoryDiscovery::findUrlFactory()->createUri($uri);
        }
        throw new \LogicException(\sprintf('You cannot use "%s()" as the "nyholm/psr7" package is not installed. Try running "composer require nyholm/psr7".', __METHOD__));
    }
    public function reset()
    {
        if ($this->client instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface) {
            $this->client->reset();
        }
    }
}
/**
 * @internal
 */
class Psr18NetworkException extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\Psr\Http\Client\NetworkExceptionInterface
{
    private $request;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface $e, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface $request)
    {
        parent::__construct($e->getMessage(), 0, $e);
        $this->request = $request;
    }
    public function getRequest() : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface
    {
        return $this->request;
    }
}
/**
 * @internal
 */
class Psr18RequestException extends \InvalidArgumentException implements \ZOOlanders\YOOessentials\Vendor\Psr\Http\Client\RequestExceptionInterface
{
    private $request;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface $e, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface $request)
    {
        parent::__construct($e->getMessage(), 0, $e);
        $this->request = $request;
    }
    public function getRequest() : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface
    {
        return $this->request;
    }
}
