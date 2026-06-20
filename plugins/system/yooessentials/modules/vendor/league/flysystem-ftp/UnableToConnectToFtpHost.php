<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp;

use RuntimeException;
final class UnableToConnectToFtpHost extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionException
{
    public static function forHost(string $host, int $port, bool $ssl) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToConnectToFtpHost
    {
        $usingSsl = $ssl ? ', using ssl' : '';
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToConnectToFtpHost("Unable to connect to host {$host} at port {$port}{$usingSsl}.");
    }
}
