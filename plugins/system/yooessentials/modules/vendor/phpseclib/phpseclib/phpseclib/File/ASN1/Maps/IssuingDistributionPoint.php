<?php

/**
 * IssuingDistributionPoint
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
 * IssuingDistributionPoint
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class IssuingDistributionPoint
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['distributionPoint' => ['constant' => 0, 'optional' => \true, 'explicit' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\DistributionPointName::MAP, 'onlyContainsUserCerts' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_BOOLEAN, 'constant' => 1, 'optional' => \true, 'default' => \false, 'implicit' => \true], 'onlyContainsCACerts' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_BOOLEAN, 'constant' => 2, 'optional' => \true, 'default' => \false, 'implicit' => \true], 'onlySomeReasons' => ['constant' => 3, 'optional' => \true, 'implicit' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\ReasonFlags::MAP, 'indirectCRL' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_BOOLEAN, 'constant' => 4, 'optional' => \true, 'default' => \false, 'implicit' => \true], 'onlyContainsAttributeCerts' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_BOOLEAN, 'constant' => 5, 'optional' => \true, 'default' => \false, 'implicit' => \true]]];
}
