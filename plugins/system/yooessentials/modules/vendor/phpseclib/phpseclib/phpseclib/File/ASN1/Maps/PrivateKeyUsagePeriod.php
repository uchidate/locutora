<?php

/**
 * PrivateKeyUsagePeriod
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
 * PrivateKeyUsagePeriod
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class PrivateKeyUsagePeriod
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['notBefore' => ['constant' => 0, 'optional' => \true, 'implicit' => \true, 'type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_GENERALIZED_TIME], 'notAfter' => ['constant' => 1, 'optional' => \true, 'implicit' => \true, 'type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_GENERALIZED_TIME]]];
}
