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

/*
 * Class with static methods for various small handy tools for strings
 */
class Interpolation
{
    /*
     * Interpolate string with values of asociative array
     *
     * @params string $message The string to interpolate
     * @params array $context The associative array, contains values for interpolation
     * @return string
     *
     * @throws \InvalidArgumentException
    */
    public function _($str, array $hash = [])
    {
        //_("%(foobar).2d", ['foobar => 0.5'])
        $args = [];
        $format = preg_replace_callback(
            '/[^(]?%(\([a-z_][a-z0-9_]*?\))/i',
            function ($matches) use ($str, $hash, &$args) {
                if (preg_match('/^%%/', $matches[0])) {
                    // pattern has being escaped - do not touch!
                    return $matches[0];
                }
                preg_match('/(.?%)(\(.+?\))/', $matches[0], $m);
                $key = preg_replace('/[\(\)]/', '', $m[2]);
                if (!isset($hash[$key])) {
                    return '%' . $m[1] . $m[2];
                }

                array_push($args, $hash[$key]);
                return preg_replace('/^(.?\%)(.+)/', "\\1", $matches[0]);
            },
            $str
        );
        array_unshift($args, $format);
        return call_user_func_array('sprintf', $args);
    }
}
