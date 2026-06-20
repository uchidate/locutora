<?php

/**
 * CertificationRequestInfo
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
 * CertificationRequestInfo
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class CertificationRequestInfo
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['version' => ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_INTEGER, 'mapping' => ['v1']], 'subject' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Name::MAP, 'subjectPKInfo' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\SubjectPublicKeyInfo::MAP, 'attributes' => ['constant' => 0, 'optional' => \true, 'implicit' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Attributes::MAP]];
}
