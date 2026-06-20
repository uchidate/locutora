<?php

namespace ZOOlanders\YOOessentials\Vendor;

if (\class_exists('ZOOlanders\\YOOessentials\\Vendor\\Google_Client', \false)) {
    // Prevent error with preloading in PHP 7.4
    // @see https://github.com/googleapis/google-api-php-client/issues/1976
    return;
}
$classMap = ['ZOOlanders\\YOOessentials\\Vendor\\Google\\Client' => 'ZOOlanders\YOOessentials\Vendor\Google_Client', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Service' => 'ZOOlanders\YOOessentials\Vendor\Google_Service', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\AccessToken\\Revoke' => 'ZOOlanders\YOOessentials\Vendor\Google_AccessToken_Revoke', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\AccessToken\\Verify' => 'ZOOlanders\YOOessentials\Vendor\Google_AccessToken_Verify', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Model' => 'ZOOlanders\YOOessentials\Vendor\Google_Model', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Utils\\UriTemplate' => 'ZOOlanders\YOOessentials\Vendor\Google_Utils_UriTemplate', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\AuthHandler\\Guzzle6AuthHandler' => 'ZOOlanders\YOOessentials\Vendor\Google_AuthHandler_Guzzle6AuthHandler', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\AuthHandler\\Guzzle7AuthHandler' => 'ZOOlanders\YOOessentials\Vendor\Google_AuthHandler_Guzzle7AuthHandler', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\AuthHandler\\Guzzle5AuthHandler' => 'ZOOlanders\YOOessentials\Vendor\Google_AuthHandler_Guzzle5AuthHandler', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\AuthHandler\\AuthHandlerFactory' => 'ZOOlanders\YOOessentials\Vendor\Google_AuthHandler_AuthHandlerFactory', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Http\\Batch' => 'ZOOlanders\YOOessentials\Vendor\Google_Http_Batch', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Http\\MediaFileUpload' => 'ZOOlanders\YOOessentials\Vendor\Google_Http_MediaFileUpload', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Http\\REST' => 'ZOOlanders\YOOessentials\Vendor\Google_Http_REST', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Task\\Retryable' => 'ZOOlanders\YOOessentials\Vendor\Google_Task_Retryable', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Task\\Exception' => 'ZOOlanders\YOOessentials\Vendor\Google_Task_Exception', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Task\\Runner' => 'ZOOlanders\YOOessentials\Vendor\Google_Task_Runner', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Collection' => 'ZOOlanders\YOOessentials\Vendor\Google_Collection', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Service\\Exception' => 'ZOOlanders\YOOessentials\Vendor\Google_Service_Exception', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Service\\Resource' => 'ZOOlanders\YOOessentials\Vendor\Google_Service_Resource', 'ZOOlanders\\YOOessentials\\Vendor\\Google\\Exception' => 'ZOOlanders\YOOessentials\Vendor\Google_Exception'];
foreach ($classMap as $class => $alias) {
    \class_alias($class, $alias);
}
/**
 * This class needs to be defined explicitly as scripts must be recognized by
 * the autoloader.
 */
class Google_Task_Composer extends \ZOOlanders\YOOessentials\Vendor\Google\Task\Composer
{
}
/** @phpstan-ignore-next-line */
if (\false) {
    class Google_AccessToken_Revoke extends \ZOOlanders\YOOessentials\Vendor\Google\AccessToken\Revoke
    {
    }
    class Google_AccessToken_Verify extends \ZOOlanders\YOOessentials\Vendor\Google\AccessToken\Verify
    {
    }
    class Google_AuthHandler_AuthHandlerFactory extends \ZOOlanders\YOOessentials\Vendor\Google\AuthHandler\AuthHandlerFactory
    {
    }
    class Google_AuthHandler_Guzzle5AuthHandler extends \ZOOlanders\YOOessentials\Vendor\Google\AuthHandler\Guzzle5AuthHandler
    {
    }
    class Google_AuthHandler_Guzzle6AuthHandler extends \ZOOlanders\YOOessentials\Vendor\Google\AuthHandler\Guzzle6AuthHandler
    {
    }
    class Google_AuthHandler_Guzzle7AuthHandler extends \ZOOlanders\YOOessentials\Vendor\Google\AuthHandler\Guzzle7AuthHandler
    {
    }
    class Google_Client extends \ZOOlanders\YOOessentials\Vendor\Google\Client
    {
    }
    class Google_Collection extends \ZOOlanders\YOOessentials\Vendor\Google\Collection
    {
    }
    class Google_Exception extends \ZOOlanders\YOOessentials\Vendor\Google\Exception
    {
    }
    class Google_Http_Batch extends \ZOOlanders\YOOessentials\Vendor\Google\Http\Batch
    {
    }
    class Google_Http_MediaFileUpload extends \ZOOlanders\YOOessentials\Vendor\Google\Http\MediaFileUpload
    {
    }
    class Google_Http_REST extends \ZOOlanders\YOOessentials\Vendor\Google\Http\REST
    {
    }
    class Google_Model extends \ZOOlanders\YOOessentials\Vendor\Google\Model
    {
    }
    class Google_Service extends \ZOOlanders\YOOessentials\Vendor\Google\Service
    {
    }
    class Google_Service_Exception extends \ZOOlanders\YOOessentials\Vendor\Google\Service\Exception
    {
    }
    class Google_Service_Resource extends \ZOOlanders\YOOessentials\Vendor\Google\Service\Resource
    {
    }
    class Google_Task_Exception extends \ZOOlanders\YOOessentials\Vendor\Google\Task\Exception
    {
    }
    interface Google_Task_Retryable extends \ZOOlanders\YOOessentials\Vendor\Google\Task\Retryable
    {
    }
    class Google_Task_Runner extends \ZOOlanders\YOOessentials\Vendor\Google\Task\Runner
    {
    }
    class Google_Utils_UriTemplate extends \ZOOlanders\YOOessentials\Vendor\Google\Utils\UriTemplate
    {
    }
}
