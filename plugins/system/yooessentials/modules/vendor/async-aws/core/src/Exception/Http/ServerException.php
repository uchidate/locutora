<?php

declare (strict_types=1);
namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http;

use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
/**
 * Represents a 5xx response.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ServerException extends \RuntimeException implements \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\HttpException, \ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
{
    use HttpExceptionTrait;
}
