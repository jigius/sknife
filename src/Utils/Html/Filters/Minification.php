<?php
namespace jigius\sknife\Utils\Html\Filters;

class Minification
{
    public function _($obj)
    {
        if (!is_string($obj)) {
            throw new \InvalidArgument("string type is expected");
        }
        $output = preg_replace('/(\s*\\r?\\n\s*)/', '', $obj);
        return $output !== null? $output: $obj;
    }
}
