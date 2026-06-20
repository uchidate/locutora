<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\Header;

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\Address;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\Exception\RfcComplianceException;
/**
 * A Path Header, such a Return-Path (one address).
 *
 * @author Chris Corbyn
 */
final class PathHeader extends \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\Header\AbstractHeader
{
    private $address;
    public function __construct(string $name, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\Address $address)
    {
        parent::__construct($name);
        $this->setAddress($address);
    }
    /**
     * @param Address $body
     *
     * @throws RfcComplianceException
     */
    public function setBody($body)
    {
        $this->setAddress($body);
    }
    public function getBody() : \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\Address
    {
        return $this->getAddress();
    }
    public function setAddress(\ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\Address $address)
    {
        $this->address = $address;
    }
    public function getAddress() : \ZOOlanders\YOOessentials\Vendor\Symfony\Component\Mime\Address
    {
        return $this->address;
    }
    public function getBodyAsString() : string
    {
        return '<' . $this->address->toString() . '>';
    }
}
