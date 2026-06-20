<?php

namespace ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Signer;

use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Request;
use ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\RequestContext;
/**
 * Interface for signing a request.
 *
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
interface Signer
{
    public function sign(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Request $request, \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials $credentials, \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\RequestContext $context) : void;
    public function presign(\ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Request $request, \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\Credentials\Credentials $credentials, \ZOOlanders\YOOessentials\Vendor\AsyncAws\Core\RequestContext $context) : void;
}
