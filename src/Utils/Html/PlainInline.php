<?php
namespace jigius\sknife\Utils\Html;

use jigius\sknife\Utils\Snippet;
use jigius\sknife\Foundation;

class PlainInline extends Foundation\Singleton
{
    private $snippet;

    protected static $instance;

    private function __construct()
    {
        $this->snippet = new Snippet\Collection();
    }

    /*
     * Proxing called methods
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->snippet, $name], $arguments);
    }

    public function output($compact = false)
    {
        $output = array_map(
            function ($item) {
                return $item->output();
            },
            $this->snippet->getIterator()->getArrayCopy()
        );
        if (!count($output)) {
            return "";
        }
        return implode("\r\n", $output);
    }
}
