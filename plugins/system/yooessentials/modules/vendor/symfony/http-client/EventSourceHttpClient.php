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

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ServerSentEvent;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\EventSourceException;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncContext;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncResponse;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ChunkInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface;
/**
 * @author Antoine Bluchet <soyuka@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 */
final class EventSourceHttpClient implements \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface, \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\Service\ResetInterface
{
    use AsyncDecoratorTrait, HttpClientTrait {
        AsyncDecoratorTrait::withOptions insteadof HttpClientTrait;
    }
    private $reconnectionTime;
    public function __construct(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\HttpClientInterface $client = null, float $reconnectionTime = 10.0)
    {
        $this->client = $client ?? \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\HttpClient::create();
        $this->reconnectionTime = $reconnectionTime;
    }
    public function connect(string $url, array $options = []) : \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface
    {
        return $this->request('GET', $url, self::mergeDefaultOptions($options, ['buffer' => \false, 'headers' => ['Accept' => 'text/event-stream', 'Cache-Control' => 'no-cache']], \true));
    }
    public function request(string $method, string $url, array $options = []) : \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface
    {
        $state = new class
        {
            public $buffer = null;
            public $lastEventId = null;
            public $reconnectionTime;
            public $lastError = null;
        };
        $state->reconnectionTime = $this->reconnectionTime;
        if ($accept = self::normalizeHeaders($options['headers'] ?? [])['accept'] ?? []) {
            $state->buffer = \in_array($accept, [['Accept: text/event-stream'], ['accept: text/event-stream']], \true) ? '' : null;
            if (null !== $state->buffer) {
                $options['extra']['trace_content'] = \false;
            }
        }
        return new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncResponse($this->client, $method, $url, $options, static function (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ChunkInterface $chunk, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Response\AsyncContext $context) use($state, $method, $url, $options) {
            if (null !== $state->buffer) {
                $context->setInfo('reconnection_time', $state->reconnectionTime);
                $isTimeout = \false;
            }
            $lastError = $state->lastError;
            $state->lastError = null;
            try {
                $isTimeout = $chunk->isTimeout();
                if (null !== $chunk->getInformationalStatus() || $context->getInfo('canceled')) {
                    (yield $chunk);
                    return;
                }
            } catch (\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface $e) {
                $state->lastError = $lastError ?? \microtime(\true);
                if (null === $state->buffer || $isTimeout && \microtime(\true) - $state->lastError < $state->reconnectionTime) {
                    (yield $chunk);
                } else {
                    $options['headers']['Last-Event-ID'] = $state->lastEventId;
                    $state->buffer = '';
                    $state->lastError = \microtime(\true);
                    $context->getResponse()->cancel();
                    $context->replaceRequest($method, $url, $options);
                    if ($isTimeout) {
                        (yield $chunk);
                    } else {
                        $context->pause($state->reconnectionTime);
                    }
                }
                return;
            }
            if ($chunk->isFirst()) {
                if (\preg_match('/^text\\/event-stream(;|$)/i', $context->getHeaders()['content-type'][0] ?? '')) {
                    $state->buffer = '';
                } elseif (null !== $lastError || null !== $state->buffer && 200 === $context->getStatusCode()) {
                    throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\EventSourceException(\sprintf('Response content-type is "%s" while "text/event-stream" was expected for "%s".', $context->getHeaders()['content-type'][0] ?? '', $context->getInfo('url')));
                } else {
                    $context->passthru();
                }
                if (null === $lastError) {
                    (yield $chunk);
                }
                return;
            }
            $rx = '/((?:\\r\\n|[\\r\\n]){2,})/';
            $content = $state->buffer . $chunk->getContent();
            if ($chunk->isLast()) {
                $rx = \substr_replace($rx, '|$', -2, 0);
            }
            $events = \preg_split($rx, $content, -1, \PREG_SPLIT_DELIM_CAPTURE);
            $state->buffer = \array_pop($events);
            for ($i = 0; isset($events[$i]); $i += 2) {
                $event = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Chunk\ServerSentEvent($events[$i] . $events[1 + $i]);
                if ('' !== $event->getId()) {
                    $context->setInfo('last_event_id', $state->lastEventId = $event->getId());
                }
                if ($event->getRetry()) {
                    $context->setInfo('reconnection_time', $state->reconnectionTime = $event->getRetry());
                }
                (yield $event);
            }
            if (\preg_match('/^(?::[^\\r\\n]*+(?:\\r\\n|[\\r\\n]))+$/m', $state->buffer)) {
                $content = $state->buffer;
                $state->buffer = '';
                (yield $context->createChunk($content));
            }
            if ($chunk->isLast()) {
                (yield $chunk);
            }
        });
    }
}
