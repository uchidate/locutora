<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster;

use ZOOlanders\YOOessentials\Vendor\Imagine\Image\ImageInterface;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
final class ImagineCaster
{
    public static function castImage(\ZOOlanders\YOOessentials\Vendor\Imagine\Image\ImageInterface $c, array $a, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested) : array
    {
        $imgData = $c->get('png');
        if (\strlen($imgData) > 1 * 1000 * 1000) {
            $a += [\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'image' => new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\ConstStub($c->getSize())];
        } else {
            $a += [\ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'image' => new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\ImgStub($imgData, 'image/png', $c->getSize())];
        }
        return $a;
    }
}
