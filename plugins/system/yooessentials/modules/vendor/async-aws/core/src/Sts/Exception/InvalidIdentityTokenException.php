<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Sts\Exception;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\ClientException;
use ZOOlanders\YOOessentials\Vendor\Symfony\Contracts\HttpClient\ResponseInterface;
/**
 * The web identity token that was passed could not be validated by Amazon Web Services. Get a new identity token from
 * the identity provider and then retry the request.
 */
final class InvalidIdentityTokenException extends \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Exception\Http\ClientException
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
