<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response;

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\FirstChunk;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\LastChunk;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ChunkInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
/**
 * Provides a single extension point to process a response's content stream.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
final class AsyncResponse implements \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\StreamableInterface
{
    use CommonResponseTrait;
    private const FIRST_CHUNK_YIELDED = 1;
    private const LAST_CHUNK_YIELDED = 2;
    private $client;
    private $response;
    private $info = ['canceled' => \false];
    private $passthru;
    private $stream;
    private $yieldedState;
    /**
     * @param ?callable(ChunkInterface, AsyncContext): ?\Iterator $passthru
     */
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $client, string $method, string $url, array $options, callable $passthru = null)
    {
        $this->client = $client;
        $this->shouldBuffer = $options['buffer'] ?? \true;
        if (null !== ($onProgress = $options['on_progress'] ?? null)) {
            $thisInfo =& $this->info;
            $options['on_progress'] = static function (int $dlNow, int $dlSize, array $info) use(&$thisInfo, $onProgress) {
                $onProgress($dlNow, $dlSize, $thisInfo + $info);
            };
        }
        $this->response = $client->request($method, $url, ['buffer' => \false] + $options);
        $this->passthru = $passthru;
        $this->initializer = static function (self $response, float $timeout = null) {
            if (null === $response->shouldBuffer) {
                return \false;
            }
            while (\true) {
                foreach (self::stream([$response], $timeout) as $chunk) {
                    if ($chunk->isTimeout() && $response->passthru) {
                        foreach (self::passthru($response->client, $response, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk($response->offset, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException($chunk->getError()))) as $chunk) {
                            if ($chunk->isFirst()) {
                                return \false;
                            }
                        }
                        continue 2;
                    }
                    if ($chunk->isFirst()) {
                        return \false;
                    }
                }
                return \false;
            }
        };
        if (\array_key_exists('user_data', $options)) {
            $this->info['user_data'] = $options['user_data'];
        }
        if (\array_key_exists('max_duration', $options)) {
            $this->info['max_duration'] = $options['max_duration'];
        }
    }
    public function getStatusCode() : int
    {
        if ($this->initializer) {
            self::initialize($this);
        }
        return $this->response->getStatusCode();
    }
    public function getHeaders(bool $throw = \true) : array
    {
        if ($this->initializer) {
            self::initialize($this);
        }
        $headers = $this->response->getHeaders(\false);
        if ($throw) {
            $this->checkStatusCode();
        }
        return $headers;
    }
    public function getInfo(string $type = null)
    {
        if (null !== $type) {
            return $this->info[$type] ?? $this->response->getInfo($type);
        }
        return $this->info + $this->response->getInfo();
    }
    /**
     * {@inheritdoc}
     */
    public function toStream(bool $throw = \true)
    {
        if ($throw) {
            // Ensure headers arrived
            $this->getHeaders(\true);
        }
        $handle = function () {
            $stream = $this->response instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\StreamableInterface ? $this->response->toStream(\false) : \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\StreamWrapper::createResource($this->response);
            return \stream_get_meta_data($stream)['wrapper_data']->stream_cast(\STREAM_CAST_FOR_SELECT);
        };
        $stream = \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\StreamWrapper::createResource($this);
        \stream_get_meta_data($stream)['wrapper_data']->bindHandles($handle, $this->content);
        return $stream;
    }
    /**
     * {@inheritdoc}
     */
    public function cancel() : void
    {
        if ($this->info['canceled']) {
            return;
        }
        $this->info['canceled'] = \true;
        $this->info['error'] = 'Response has been canceled.';
        $this->close();
        $client = $this->client;
        $this->client = null;
        if (!$this->passthru) {
            return;
        }
        try {
            foreach (self::passthru($client, $this, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\LastChunk()) as $chunk) {
                // no-op
            }
            $this->passthru = null;
        } catch (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\ExceptionInterface $e) {
            // ignore any errors when canceling
        }
    }
    public function __destruct()
    {
        $httpException = null;
        if ($this->initializer && null === $this->getInfo('error')) {
            try {
                self::initialize($this, -0.0);
                $this->getHeaders(\true);
            } catch (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface $httpException) {
                // no-op
            }
        }
        if ($this->passthru && null === $this->getInfo('error')) {
            $this->info['canceled'] = \true;
            try {
                foreach (self::passthru($this->client, $this, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\LastChunk()) as $chunk) {
                    // no-op
                }
            } catch (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\ExceptionInterface $e) {
                // ignore any errors when destructing
            }
        }
        if (null !== $httpException) {
            throw $httpException;
        }
    }
    /**
     * @internal
     */
    public static function stream(iterable $responses, float $timeout = null, string $class = null) : \Generator
    {
        while ($responses) {
            $wrappedResponses = [];
            $asyncMap = new \SplObjectStorage();
            $client = null;
            foreach ($responses as $r) {
                if (!$r instanceof self) {
                    throw new \TypeError(\sprintf('"%s::stream()" expects parameter 1 to be an iterable of AsyncResponse objects, "%s" given.', $class ?? static::class, \get_debug_type($r)));
                }
                if (null !== ($e = $r->info['error'] ?? null)) {
                    (yield $r => $chunk = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk($r->offset, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException($e)));
                    $chunk->didThrow() ?: $chunk->getContent();
                    continue;
                }
                if (null === $client) {
                    $client = $r->client;
                } elseif ($r->client !== $client) {
                    throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException('Cannot stream AsyncResponse objects with many clients.');
                }
                $asyncMap[$r->response] = $r;
                $wrappedResponses[] = $r->response;
                if ($r->stream) {
                    yield from self::passthruStream($response = $r->response, $r, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\FirstChunk(), $asyncMap);
                    if (!isset($asyncMap[$response])) {
                        \array_pop($wrappedResponses);
                    }
                    if ($r->response !== $response && !isset($asyncMap[$r->response])) {
                        $asyncMap[$r->response] = $r;
                        $wrappedResponses[] = $r->response;
                    }
                }
            }
            if (!$client || !$wrappedResponses) {
                return;
            }
            foreach ($client->stream($wrappedResponses, $timeout) as $response => $chunk) {
                $r = $asyncMap[$response];
                if (null === $chunk->getError()) {
                    if ($chunk->isFirst()) {
                        // Ensure no exception is thrown on destruct for the wrapped response
                        $r->response->getStatusCode();
                    } elseif (0 === $r->offset && null === $r->content && $chunk->isLast()) {
                        $r->content = \fopen('php://memory', 'w+');
                    }
                }
                if (!$r->passthru) {
                    if (null !== $chunk->getError() || $chunk->isLast()) {
                        unset($asyncMap[$response]);
                    } elseif (null !== $r->content && '' !== ($content = $chunk->getContent()) && \strlen($content) !== \fwrite($r->content, $content)) {
                        $chunk = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk($r->offset, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException(\sprintf('Failed writing %d bytes to the response buffer.', \strlen($content))));
                        $r->info['error'] = $chunk->getError();
                        $r->response->cancel();
                    }
                    (yield $r => $chunk);
                    continue;
                }
                if (null !== $chunk->getError()) {
                    // no-op
                } elseif ($chunk->isFirst()) {
                    $r->yieldedState = self::FIRST_CHUNK_YIELDED;
                } elseif (self::FIRST_CHUNK_YIELDED !== $r->yieldedState && null === $chunk->getInformationalStatus()) {
                    throw new \LogicException(\sprintf('Instance of "%s" is already consumed and cannot be managed by "%s". A decorated client should not call any of the response\'s methods in its "request()" method.', \get_debug_type($response), $class ?? static::class));
                }
                foreach (self::passthru($r->client, $r, $chunk, $asyncMap) as $chunk) {
                    (yield $r => $chunk);
                }
                if ($r->response !== $response && isset($asyncMap[$response])) {
                    break;
                }
            }
            if (null === $chunk->getError() && $chunk->isLast()) {
                $r->yieldedState = self::LAST_CHUNK_YIELDED;
            }
            if (null === $chunk->getError() && self::LAST_CHUNK_YIELDED !== $r->yieldedState && $r->response === $response && null !== $r->client) {
                throw new \LogicException('A chunk passthru must yield an "isLast()" chunk before ending a stream.');
            }
            $responses = [];
            foreach ($asyncMap as $response) {
                $r = $asyncMap[$response];
                if (null !== $r->client) {
                    $responses[] = $asyncMap[$response];
                }
            }
        }
    }
    /**
     * @param \SplObjectStorage<ResponseInterface, AsyncResponse>|null $asyncMap
     */
    private static function passthru(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $client, self $r, \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ChunkInterface $chunk, \SplObjectStorage $asyncMap = null) : \Generator
    {
        $r->stream = null;
        $response = $r->response;
        $context = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncContext($r->passthru, $client, $r->response, $r->info, $r->content, $r->offset);
        if (null === ($stream = ($r->passthru)($chunk, $context))) {
            if ($r->response === $response && (null !== $chunk->getError() || $chunk->isLast())) {
                throw new \LogicException('A chunk passthru cannot swallow the last chunk.');
            }
            return;
        }
        if (!$stream instanceof \Iterator) {
            throw new \LogicException(\sprintf('A chunk passthru must return an "Iterator", "%s" returned.', \get_debug_type($stream)));
        }
        $r->stream = $stream;
        yield from self::passthruStream($response, $r, null, $asyncMap);
    }
    /**
     * @param \SplObjectStorage<ResponseInterface, AsyncResponse>|null $asyncMap
     */
    private static function passthruStream(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface $response, self $r, ?\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ChunkInterface $chunk, ?\SplObjectStorage $asyncMap) : \Generator
    {
        while (\true) {
            try {
                if (null !== $chunk && $r->stream) {
                    $r->stream->next();
                }
                if (!$r->stream || !$r->stream->valid() || !$r->stream) {
                    $r->stream = null;
                    break;
                }
            } catch (\Throwable $e) {
                unset($asyncMap[$response]);
                $r->stream = null;
                $r->info['error'] = $e->getMessage();
                $r->response->cancel();
                (yield $r => $chunk = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk($r->offset, $e));
                $chunk->didThrow() ?: $chunk->getContent();
                break;
            }
            $chunk = $r->stream->current();
            if (!$chunk instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ChunkInterface) {
                throw new \LogicException(\sprintf('A chunk passthru must yield instances of "%s", "%s" yielded.', \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ChunkInterface::class, \get_debug_type($chunk)));
            }
            if (null !== $chunk->getError()) {
                // no-op
            } elseif ($chunk->isFirst()) {
                $e = $r->openBuffer();
                (yield $r => $chunk);
                if ($r->initializer && null === $r->getInfo('error')) {
                    // Ensure the HTTP status code is always checked
                    $r->getHeaders(\true);
                }
                if (null === $e) {
                    continue;
                }
                $r->response->cancel();
                $chunk = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk($r->offset, $e);
            } elseif ('' !== ($content = $chunk->getContent())) {
                if (null !== $r->shouldBuffer) {
                    throw new \LogicException('A chunk passthru must yield an "isFirst()" chunk before any content chunk.');
                }
                if (null !== $r->content && \strlen($content) !== \fwrite($r->content, $content)) {
                    $chunk = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk($r->offset, new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException(\sprintf('Failed writing %d bytes to the response buffer.', \strlen($content))));
                    $r->info['error'] = $chunk->getError();
                    $r->response->cancel();
                }
            }
            if (null !== $chunk->getError() || $chunk->isLast()) {
                $stream = $r->stream;
                $r->stream = null;
                unset($asyncMap[$response]);
            }
            if (null === $chunk->getError()) {
                $r->offset += \strlen($content);
                (yield $r => $chunk);
                if (!$chunk->isLast()) {
                    continue;
                }
                $stream->next();
                if ($stream->valid()) {
                    throw new \LogicException('A chunk passthru cannot yield after an "isLast()" chunk.');
                }
                $r->passthru = null;
            } else {
                if ($chunk instanceof \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk) {
                    $chunk->didThrow(\false);
                } else {
                    try {
                        $chunk = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk($chunk->getOffset(), !$chunk->isTimeout() ?: $chunk->getError());
                    } catch (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface $e) {
                        $chunk = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ErrorChunk($chunk->getOffset(), $e);
                    }
                }
                (yield $r => $chunk);
                $chunk->didThrow() ?: $chunk->getContent();
            }
            break;
        }
    }
    private function openBuffer() : ?\Throwable
    {
        if (null === ($shouldBuffer = $this->shouldBuffer)) {
            throw new \LogicException('A chunk passthru cannot yield more than one "isFirst()" chunk.');
        }
        $e = $this->shouldBuffer = null;
        if ($shouldBuffer instanceof \Closure) {
            try {
                $shouldBuffer = $shouldBuffer($this->getHeaders(\false));
                if (null !== ($e = $this->response->getInfo('error'))) {
                    throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException($e);
                }
            } catch (\Throwable $e) {
                $this->info['error'] = $e->getMessage();
                $this->response->cancel();
            }
        }
        if (\true === $shouldBuffer) {
            $this->content = \fopen('php://temp', 'w+');
        } elseif (\is_resource($shouldBuffer)) {
            $this->content = $shouldBuffer;
        }
        return $e;
    }
    private function close() : void
    {
        $this->response->cancel();
    }
}
