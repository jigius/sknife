<?php
/*
 * This file is part of the utils library.
 *
 * (c) Eduard Chernikov <jigius@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jigius\utils;

use PHPUnit\Framework\TestCase;
use jigius\sknife\Utils\Text;

class InterpolationTest extends TestCase
{
    /*
     * Test creating with various params
     */
    public function paramSuccessProvider()
    {
        return [
            [["", [], ""]],
            [["", ['b2' => 'a', 'c' => '45'], ""]],
            [["%%%%(a)s", ['a' => 'b'], "%%(a)s"]],
            [["a%(b)s%(c).3fd", [], "a%(b)s%(c).3fd"]],
            [["a%(b)s%(c).3fd", ['b' => 'a', 'c' => '45'], "aa45.000d"]],
            [["a%%(b)s%(c).3fd", ['b' => 'a', 'c' => '45'], "a%(b)s45.000d"]],
            [["a%(b)s%(c).3fd", ['b2' => 'a', 'c' => '45'], "a%(b)s45.000d"]],
        ];
    }

    /**
     * @dataProvider ParamSuccessProvider
     */
    public function testValidationOfRanges($param)
    {
        $i = Text\Interpolation();
        $this->assertEquals($i->_($param[0], $param[1]), $param[2]);
    }

    /*
     * Test creating with various params
     */
    public function paramFailureProvider()
    {
        return [
            [["%s", []]],
            [["%%%(a)s", ['a' => 'b']]],
            [["a%(b)s%(c).3fd%s", ['b2' => 'a', 'c' => '45']]]
        ];
    }

    /**
     * @dataProvider paramFailureProvider
     */
    public function testExpectedExceptionIsRaised($param)
    {
        $this->expectException(\InvalidArgumentException::class);
        $i = Text\Interpolation();
        $i->_($param[0], $param[1]);
    }
}
