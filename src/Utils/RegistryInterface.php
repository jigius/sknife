<?php
/*
 * This file is part of the registry library.
 *
 * (c) Eduard Chernikov <jigius@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jigius\sknife\Utils;

interface RegistryInterface
{
    public function isEmpty();

    public function all();

    public function remove($key, $collapseEmpty = true);

    public function get($key, $default = null);

    public function set($key, $val);

    public function append($key, $val);

    public function __set($key, $val);

    public function __get($key);

    public function __isset($key);

    public function __unset($key);

    public function import($key, callable $func);
}
