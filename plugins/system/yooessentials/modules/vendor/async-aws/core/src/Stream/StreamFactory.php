<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\InvalidArgument;
/**
 * Create Streams.
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class StreamFactory
{
    public static function create($content, int $preferredChunkSize = 64 * 1024) : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\RequestStream
    {
        if (null === $content || \is_string($content)) {
            return \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\StringStream::create($content ?? '');
        }
        if (\is_callable($content)) {
            return \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\CallableStream::create($content, $preferredChunkSize);
        }
        if (\is_iterable($content)) {
            return \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\IterableStream::create($content);
        }
        if (\is_resource($content)) {
            return \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\ResourceStream::create($content, $preferredChunkSize);
        }
        throw new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\InvalidArgument(\sprintf('Unexpected content type "%s".', \is_object($content) ? \get_class($content) : \gettype($content)));
    }
}
