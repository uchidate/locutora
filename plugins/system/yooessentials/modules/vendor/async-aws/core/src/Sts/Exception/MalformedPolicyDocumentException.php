<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\ClientException;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
/**
 * The request was rejected because the policy document was malformed. The error message describes the specific error.
 */
final class MalformedPolicyDocumentException extends \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\ClientException
{
    protected function populateResult(\ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface $response) : void
    {
        $data = new \SimpleXMLElement($response->getContent(\false));
        if (0 < $data->Error->count()) {
            $data = $data->Error;
        }
        if (null !== ($v = ($v = $data->message) ? (string) $v : null)) {
            $this->message = $v;
        }
    }
}
