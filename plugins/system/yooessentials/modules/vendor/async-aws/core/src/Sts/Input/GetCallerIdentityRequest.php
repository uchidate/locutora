<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Input;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Input;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Request;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\StreamFactory;
final class GetCallerIdentityRequest extends \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Input
{
    /**
     * @param array{
     *   @region?: string,
     * } $input
     */
    public function __construct(array $input = [])
    {
        parent::__construct($input);
    }
    public static function create($input) : self
    {
        return $input instanceof self ? $input : new self($input);
    }
    /**
     * @internal
     */
    public function request() : \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Request
    {
        // Prepare headers
        $headers = ['content-type' => 'application/x-www-form-urlencoded'];
        // Prepare query
        $query = [];
        // Prepare URI
        $uriString = '/';
        // Prepare Body
        $body = \http_build_query(['Action' => 'GetCallerIdentity', 'Version' => '2011-06-15'] + $this->requestBody(), '', '&', \PHP_QUERY_RFC1738);
        // Return the Request
        return new \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Request('POST', $uriString, $query, $headers, \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Stream\StreamFactory::create($body));
    }
    private function requestBody() : array
    {
        $payload = [];
        return $payload;
    }
}
