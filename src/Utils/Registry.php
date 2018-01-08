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

class Registry implements RegistryInterface
{
    protected $data;

    public function __construct(array $a = [])
    {
        $this->data = $a;
    }

    protected function &getEdge($key, $create = null)
    {
        $null = null;
        $parent =& $this->data;
        if (($ks = explode(".", $key)) > 1) {
            $key = array_pop($ks);
            foreach ($ks as $t) {
                if (!isset($parent[$t])) {
                    if ($create !== null) {
                        // create path segment
                        $parent[$t] = [];
                    } else {
                        return $null;
                    }
                } elseif (!is_array($parent[$t])) {
                    // wrong path. Return null
                    throw new \InvalidArgumentException("key has invalid path");
                }
                $parent =& $parent[$t];
            }
        }
        if (!isset($parent[$key])) {
            if ($create !== null) {
                // create edge elem
                $parent[$key] = $create;
            } else {
                return $null;
            }
        }
        return $parent[$key];
    }

    public function isEmpty()
    {
        return count($this->data) == 0;
    }

    public function all()
    {
        return $this->data;
    }

    public function remove($key, $collapseEmpty = true)
    {
        $this->data = static::delete(explode(".", $key), $this->data, $collapseEmpty);
        return $this;
    }

    protected static function delete(array $crumbs, &$data, $collapseEmpty)
    {
        $res = [];
        $cc = array_shift($crumbs);
        foreach ($data as $k => $v) {
            if ($k != $cc) {
                $res[$k] = $data[$k];
                continue;
            }

            if (count($crumbs) > 0) {
                if (!empty($r = static::delete($crumbs, $data[$k], $collapseEmpty)) || !$collapseEmpty) {
                    $res[$k] = $r;
                }
            }
        }
        return $res;
    }

    public function get($key, $default = null)
    {
        if (($edge =& $this->getEdge($key)) === null) {
            return $default;
        }
        return $edge;
    }

    public function set($key, $val)
    {
        if (0 && is_object($val) && !method_exists($val, '__set_state')) {
            throw new \InvalidArgumentException("object does not have method `__set_state`");
        }
        $edge =& $this->getEdge($key, []);
        $edge = $val;
        return $this;
    }

    public function append($key, $val)
    {
        if (0 && is_object($val) && !method_exists($val, '__set_state')) {
            throw new \InvalidArgumentException("object does not have method `__set_state`");
        }
        $edge =& $this->getEdge($key, []);
        if (!is_array($edge)) {
            throw new \InvalidArgumentException("key points to not array elem");
        }
        $edge[] = $val;
        return $this;
    }

    public function __set($key, $val)
    {
        return $this->set($key, $val);
    }

    public function __get($key)
    {
        return $this->get($key, null);
    }

    public function __isset($key)
    {
        return $this->getEdge($key) !== null;
    }

    public function __unset($key)
    {
        $this->unset($key);
    }

    public function import($key, callable $func)
    {
        if (($res = call_user_func($func)) === null || !is_array($res)) {
            throw new \RuntimeException("import func returns invalid data");
        }
        $this->set($key, $res);
    }
}
