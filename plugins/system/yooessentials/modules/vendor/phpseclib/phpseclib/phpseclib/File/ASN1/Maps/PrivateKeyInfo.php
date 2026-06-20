<?php

/**
 * PrivateKeyInfo
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
 * PrivateKeyInfo
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class PrivateKeyInfo
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['version' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_INTEGER, 'mapping' => ['v1']], 'privateKeyAlgorithm' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\AlgorithmIdentifier::MAP, 'privateKey' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\PrivateKey::MAP, 'attributes' => ['constant' => 0, 'optional' => \true, 'implicit' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Attributes::MAP]];
}
