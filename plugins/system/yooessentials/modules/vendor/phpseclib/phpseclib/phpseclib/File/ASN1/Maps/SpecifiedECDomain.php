<?php

/**
 * SpecifiedECDomain
 *
 * From: http://www.secg.org/sec1-v2.pdf#page=109
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
 * SpecifiedECDomain
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class SpecifiedECDomain
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['version' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_INTEGER, 'mapping' => [1 => 'ecdpVer1', 'ecdpVer2', 'ecdpVer3']], 'fieldID' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\FieldID::MAP, 'curve' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Curve::MAP, 'base' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\ECPoint::MAP, 'order' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_INTEGER], 'cofactor' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_INTEGER, 'optional' => \true], 'hash' => ['optional' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\HashAlgorithm::MAP]];
}
