<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Internal;

use ZOOlanders\YOOessentials\Vendor\Amp\ByteStream\InputStream;
use ZOOlanders\YOOessentials\Vendor\Amp\ByteStream\ResourceInputStream;
use ZOOlanders\YOOessentials\Vendor\Amp\Http\Client\RequestBody;
use ZOOlanders\YOOessentials\Vendor\Amp\Promise;
use ZOOlanders\YOOessentials\Vendor\Amp\Success;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
class AmpBody implements \ZOOlanders\YOOessentials\Vendor\Amp\Http\Client\RequestBody, \ZOOlanders\YOOessentials\Vendor\Amp\ByteStream\InputStream
{
    private $body;
    private $info;
    private $onProgress;
    private $offset = 0;
    private $length = -1;
    private $uploaded;
    public function __construct($body, &$info, \Closure $onProgress)
    {
        $this->body = $body;
        $this->info =& $info;
        $this->onProgress = $onProgress;
        if (\is_resource($body)) {
            $this->offset = \ftell($body);
            $this->length = \fstat($body)['size'];
            $this->body = new \ZOOlanders\YOOessentials\Vendor\Amp\ByteStream\ResourceInputStream($body);
        } elseif (\is_string($body)) {
            $this->length = \strlen($body);
        }
    }
    public function createBodyStream() : \ZOOlanders\YOOessentials\Vendor\Amp\ByteStream\InputStream
    {
        if (null !== $this->uploaded) {
            $this->uploaded = null;
            if (\is_string($this->body)) {
                $this->offset = 0;
            } elseif ($this->body instanceof \ZOOlanders\YOOessentials\Vendor\Amp\ByteStream\ResourceInputStream) {
                \fseek($this->body->getResource(), $this->offset);
            }
        }
        return $this;
    }
    public function getHeaders() : \ZOOlanders\YOOessentials\Vendor\Amp\Promise
    {
        return new \ZOOlanders\YOOessentials\Vendor\Amp\Success([]);
    }
    public function getBodyLength() : \ZOOlanders\YOOessentials\Vendor\Amp\Promise
    {
        return new \ZOOlanders\YOOessentials\Vendor\Amp\Success($this->length - $this->offset);
    }
    public function read() : \ZOOlanders\YOOessentials\Vendor\Amp\Promise
    {
        $this->info['size_upload'] += $this->uploaded;
        $this->uploaded = 0;
        ($this->onProgress)();
        $chunk = $this->doRead();
        $chunk->onResolve(function ($e, $data) {
            if (null !== $data) {
                $this->uploaded = \strlen($data);
            } else {
                $this->info['upload_content_length'] = $this->info['size_upload'];
            }
        });
        return $chunk;
    }
    public static function rewind(\ZOOlanders\YOOessentials\Vendor\Amp\Http\Client\RequestBody $body) : \ZOOlanders\YOOessentials\Vendor\Amp\Http\Client\RequestBody
    {
        if (!$body instanceof self) {
            return $body;
        }
        $body->uploaded = null;
        if ($body->body instanceof \ZOOlanders\YOOessentials\Vendor\Amp\ByteStream\ResourceInputStream) {
            \fseek($body->body->getResource(), $body->offset);
            return new $body($body->body, $body->info, $body->onProgress);
        }
        if (\is_string($body->body)) {
            $body->offset = 0;
        }
        return $body;
    }
    private function doRead() : \ZOOlanders\YOOessentials\Vendor\Amp\Promise
    {
        if ($this->body instanceof \ZOOlanders\YOOessentials\Vendor\Amp\ByteStream\ResourceInputStream) {
            return $this->body->read();
        }
        if (null === $this->offset || !$this->length) {
            return new \ZOOlanders\YOOessentials\Vendor\Amp\Success();
        }
        if (\is_string($this->body)) {
            $this->offset = null;
            return new \ZOOlanders\YOOessentials\Vendor\Amp\Success($this->body);
        }
        if ('' === ($data = ($this->body)(16372))) {
            $this->offset = null;
            return new \ZOOlanders\YOOessentials\Vendor\Amp\Success();
        }
        if (!\is_string($data)) {
            throw new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Exception\TransportException(\sprintf('Return value of the "body" option callback must be string, "%s" returned.', \get_debug_type($data)));
        }
        return new \ZOOlanders\YOOessentials\Vendor\Amp\Success($data);
    }
}
