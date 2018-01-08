<?php
namespace jigius\sknife\Utils\Snippet;

interface CollectionInterface
{
    public function get($name);

    public function fetch($name, ItemInterface $item = null);

    public function push($name, ItemInterface $item);

    public function has($name);

    public function getIterator(callable $sort = null);

    public function count();
}
