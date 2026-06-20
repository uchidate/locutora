<?php

/**
 * UserNotice
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
 * UserNotice
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class UserNotice
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['noticeRef' => ['optional' => \true, 'implicit' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\NoticeReference::MAP, 'explicitText' => ['optional' => \true, 'implicit' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\DisplayText::MAP]];
}
