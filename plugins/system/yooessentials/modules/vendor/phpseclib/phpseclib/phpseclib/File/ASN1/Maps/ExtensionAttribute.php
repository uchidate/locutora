<?php

/**
 * ExtensionAttribute
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
 * ExtensionAttribute
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class ExtensionAttribute
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['extension-attribute-type' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_PRINTABLE_STRING, 'constant' => 0, 'optional' => \true, 'implicit' => \true], 'extension-attribute-value' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_ANY, 'constant' => 1, 'optional' => \true, 'explicit' => \true]]];
}
