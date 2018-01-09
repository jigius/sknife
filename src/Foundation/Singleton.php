<?php
/*
 * This file is part of the utils library.
 *
 * (c) Eduard Chernikov <jigius@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jigius\sknife\Foundation;

abstract class Singleton implements SingletonInterface
{
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = self::instantiate(func_get_args());
        }
        return static::$instance;
    }

    final protected static function instantiate(array $args = [])
    {
        $ref = new \ReflectionClass(get_called_class());
        $self = $ref->newInstanceWithoutConstructor();
        if (($ctor = $ref->getConstructor()) !== null) {
            $ctor->setAccessible(true);
            $ctor->invokeArgs($self, $args);
        }
        return $self;
    }

    public function __clone()
    {
        throw new \RuntimeException("is prohibited");
    }

    public function __sleep()
    {
        throw new \RuntimeException("is not implemented");
    }

    public function __wakeup()
    {
        throw new \RuntimeException("is not implemented");
    }

    public function __set_state(array $array)
    {
        throw new \RuntimeException("is not implemented");
    }
}
