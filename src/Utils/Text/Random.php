<?php
/*
 * This file is part of the utils library.
 *
 * (c) Eduard Chernikov <jigius@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jigius\sknife\Utils\Text;

class Random
{
    public function random($length = 16, $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")
    {
        return substr(str_shuffle(str_repeat($x = $chars, ceil($length/strlen($x)))), 1, $length);
    }
}
