<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Exception;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
interface HttpException extends \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Exception
{
    public function getResponse() : \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
    public function getAwsCode() : ?string;
    public function getAwsType() : ?string;
    public function getAwsMessage() : ?string;
    public function getAwsDetail() : ?string;
}
