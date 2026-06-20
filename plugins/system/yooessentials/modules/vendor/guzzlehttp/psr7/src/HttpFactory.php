<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7;

use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ResponseFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ResponseInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ServerRequestFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ServerRequestInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UploadedFileFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UploadedFileInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriFactoryInterface;
use ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriInterface;
/**
 * Implements all of the PSR-17 interfaces.
 *
 * Note: in consuming code it is recommended to require the implemented interfaces
 * and inject the instance of this class multiple times.
 */
final class HttpFactory implements \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestFactoryInterface, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ResponseFactoryInterface, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ServerRequestFactoryInterface, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamFactoryInterface, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UploadedFileFactoryInterface, \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriFactoryInterface
{
    public function createUploadedFile(\ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface $stream, int $size = null, int $error = \UPLOAD_ERR_OK, string $clientFilename = null, string $clientMediaType = null) : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UploadedFileInterface
    {
        if ($size === null) {
            $size = $stream->getSize();
        }
        return new \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\UploadedFile($stream, $size, $error, $clientFilename, $clientMediaType);
    }
    public function createStream(string $content = '') : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface
    {
        return \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Utils::streamFor($content);
    }
    public function createStreamFromFile(string $file, string $mode = 'r') : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface
    {
        try {
            $resource = \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Utils::tryFopen($file, $mode);
        } catch (\RuntimeException $e) {
            if ('' === $mode || \false === \in_array($mode[0], ['r', 'w', 'a', 'x', 'c'], \true)) {
                throw new \InvalidArgumentException(\sprintf('Invalid file opening mode "%s"', $mode), 0, $e);
            }
            throw $e;
        }
        return \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Utils::streamFor($resource);
    }
    public function createStreamFromResource($resource) : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\StreamInterface
    {
        return \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Utils::streamFor($resource);
    }
    public function createServerRequest(string $method, $uri, array $serverParams = []) : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ServerRequestInterface
    {
        if (empty($method)) {
            if (!empty($serverParams['REQUEST_METHOD'])) {
                $method = $serverParams['REQUEST_METHOD'];
            } else {
                throw new \InvalidArgumentException('Cannot determine HTTP method');
            }
        }
        return new \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\ServerRequest($method, $uri, [], null, '1.1', $serverParams);
    }
    public function createResponse(int $code = 200, string $reasonPhrase = '') : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\ResponseInterface
    {
        return new \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Response($code, [], null, '1.1', $reasonPhrase);
    }
    public function createRequest(string $method, $uri) : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\RequestInterface
    {
        return new \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Request($method, $uri);
    }
    public function createUri(string $uri = '') : \ZOOlanders\YOOessentials\Vendor\Psr\Http\Message\UriInterface
    {
        return new \ZOOlanders\YOOessentials\Vendor\GuzzleHttp\Psr7\Uri($uri);
    }
}
