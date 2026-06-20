<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\S3\Enum;

final class RequestPayer
{
    public const REQUESTER = 'requester';
    public static function exists(string $value) : bool
    {
        return isset([self::REQUESTER => \true][$value]);
    }
}
