<?php

/**
 * Validity
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
 * Validity
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class Validity
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['notBefore' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Time::MAP, 'notAfter' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Time::MAP]];
}
