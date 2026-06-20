<?php

/**
 * Attribute
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
 * Attribute
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class Attribute
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\AttributeType::MAP, 'value' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SET, 'min' => 1, 'max' => -1, 'children' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\AttributeValue::MAP]]];
}
