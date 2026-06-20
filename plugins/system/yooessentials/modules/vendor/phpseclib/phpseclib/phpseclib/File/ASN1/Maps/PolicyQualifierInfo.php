<?php

/**
 * PolicyQualifierInfo
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
 * PolicyQualifierInfo
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class PolicyQualifierInfo
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['policyQualifierId' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\PolicyQualifierId::MAP, 'qualifier' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_ANY]]];
}
