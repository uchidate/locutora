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

use ZOOlanders\YOOessentials\Vendor\Doctrine\Common\Proxy\Proxy as CommonProxy;
use ZOOlanders\YOOessentials\Vendor\Doctrine\ORM\PersistentCollection;
use ZOOlanders\YOOessentials\Vendor\Doctrine\ORM\Proxy\Proxy as OrmProxy;
use ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * Casts Doctrine related classes to array representation.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final
 */
class DoctrineCaster
{
    public static function castCommonProxy(\ZOOlanders\YOOessentials\Vendor\Doctrine\Common\Proxy\Proxy $proxy, array $a, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        foreach (['__cloner__', '__initializer__'] as $k) {
            if (\array_key_exists($k, $a)) {
                unset($a[$k]);
                ++$stub->cut;
            }
        }
        return $a;
    }
    public static function castOrmProxy(\ZOOlanders\YOOessentials\Vendor\Doctrine\ORM\Proxy\Proxy $proxy, array $a, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        foreach (['_entityPersister', '_identifier'] as $k) {
            if (\array_key_exists($k = "\x00Doctrine\\ORM\\Proxy\\Proxy\x00" . $k, $a)) {
                unset($a[$k]);
                ++$stub->cut;
            }
        }
        return $a;
    }
    public static function castPersistentCollection(\ZOOlanders\YOOessentials\Vendor\Doctrine\ORM\PersistentCollection $coll, array $a, \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested)
    {
        foreach (['snapshot', 'association', 'typeClass'] as $k) {
            if (\array_key_exists($k = "\x00Doctrine\\ORM\\PersistentCollection\x00" . $k, $a)) {
                $a[$k] = new \ZOOlanders\YOOessentials\Vendor\Symfony\Component\VarDumper\Caster\CutStub($a[$k]);
            }
        }
        return $a;
    }
}
