<?php
namespace jigius\sknife\Utils\Snippet;

interface ItemInterface
{
    public function prio($num = null);

    public function prepend($text = null);

    public function postpend($text = null);

    public function count();

    public function chunk($text);

    public function output();
}
