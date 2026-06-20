<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp;

use RuntimeException;
final class UnableToAuthenticate extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\League\Flysystem\Ftp\FtpConnectionException
{
    public function __construct()
    {
        parent::__construct("Unable to login/authenticate with FTP");
    }
}
