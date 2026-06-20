<?php

/**
 * TBSCertList
 *
 * PHP version 5
 *
 * @author    Jim Wigginton <terrafrost@php.net>
 * @copyright 2016 Jim Wigginton
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      http://phpseclib.sourceforge.net
 */
namespace ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps;

use ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1;
/**
 * TBSCertList
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class TBSCertList
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['version' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_INTEGER, 'mapping' => ['v1', 'v2', 'v3'], 'optional' => \true, 'default' => 'v2'], 'signature' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\AlgorithmIdentifier::MAP, 'issuer' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Name::MAP, 'thisUpdate' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Time::MAP, 'nextUpdate' => ['optional' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Time::MAP, 'revokedCertificates' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'optional' => \true, 'min' => 0, 'max' => -1, 'children' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\RevokedCertificate::MAP], 'crlExtensions' => ['constant' => 0, 'optional' => \true, 'explicit' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Extensions::MAP]];
}
