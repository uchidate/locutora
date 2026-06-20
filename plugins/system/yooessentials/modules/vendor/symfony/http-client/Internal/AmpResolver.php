<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\HttpClient\Internal;

use ZOOlanders\YOOessentials\Vendor\Amp\Dns;
use ZOOlanders\YOOessentials\Vendor\Amp\Dns\Record;
use ZOOlanders\YOOessentials\Vendor\Amp\Promise;
use ZOOlanders\YOOessentials\Vendor\Amp\Success;
/**
 * Handles local overrides for the DNS resolver.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
class AmpResolver implements \ZOOlanders\YOOessentials\Vendor\Amp\Dns\Resolver
{
    private $dnsMap;
    public function __construct(array &$dnsMap)
    {
        $this->dnsMap =& $dnsMap;
    }
    public function resolve(string $name, int $typeRestriction = null) : \ZOOlanders\YOOessentials\Vendor\Amp\Promise
    {
        if (!isset($this->dnsMap[$name]) || !\in_array($typeRestriction, [\ZOOlanders\YOOessentials\Vendor\Amp\Dns\Record::A, null], \true)) {
            return \ZOOlanders\YOOessentials\Vendor\Amp\Dns\resolver()->resolve($name, $typeRestriction);
        }
        return new \ZOOlanders\YOOessentials\Vendor\Amp\Success([new \ZOOlanders\YOOessentials\Vendor\Amp\Dns\Record($this->dnsMap[$name], \ZOOlanders\YOOessentials\Vendor\Amp\Dns\Record::A, null)]);
    }
    public function query(string $name, int $type) : \ZOOlanders\YOOessentials\Vendor\Amp\Promise
    {
        if (!isset($this->dnsMap[$name]) || \ZOOlanders\YOOessentials\Vendor\Amp\Dns\Record::A !== $type) {
            return \ZOOlanders\YOOessentials\Vendor\Amp\Dns\resolver()->query($name, $type);
        }
        return new \ZOOlanders\YOOessentials\Vendor\Amp\Success([new \ZOOlanders\YOOessentials\Vendor\Amp\Dns\Record($this->dnsMap[$name], \ZOOlanders\YOOessentials\Vendor\Amp\Dns\Record::A, null)]);
    }
}
