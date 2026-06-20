<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp;

use RuntimeException;
class UnableToSetFtpOption extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionException
{
    public static function whileSettingOption(string $option) : \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToSetFtpOption
    {
        return new \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\UnableToSetFtpOption("Unable to set FTP option {$option}.");
    }
}
