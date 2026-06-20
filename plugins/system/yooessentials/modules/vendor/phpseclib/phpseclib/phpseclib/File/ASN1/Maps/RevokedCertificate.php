<?php

/**
 * RevokedCertificate
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
 * RevokedCertificate
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class RevokedCertificate
{
    const MAP = ['type' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1::TYPE_SEQUENCE, 'children' => ['userCertificate' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\CertificateSerialNumber::MAP, 'revocationDate' => \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Time::MAP, 'crlEntryExtensions' => ['optional' => \true] + \ZOOlanders\YOOessentials\Vendor\phpseclib3\File\ASN1\Maps\Extensions::MAP]];
}
