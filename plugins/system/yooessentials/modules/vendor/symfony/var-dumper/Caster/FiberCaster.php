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

use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * Casts Fiber related classes to array representation.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
final class FiberCaster
{
    public static function castFiber(\ZOOlanders\YOOessentials\Vendor\Fiber $fiber, array $a, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested, int $filter = 0)
    {
        $prefix = \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL;
        if ($fiber->isTerminated()) {
            $status = 'terminated';
        } elseif ($fiber->isRunning()) {
            $status = 'running';
        } elseif ($fiber->isSuspended()) {
            $status = 'suspended';
        } elseif ($fiber->isStarted()) {
            $status = 'started';
        } else {
            $status = 'not started';
        }
        $a[$prefix . 'status'] = $status;
        return $a;
    }
}
