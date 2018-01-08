<?php
namespace jigius\sknife\Utils\Snippet;

class Collection implements CollectionInterface
{
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    public function get($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('`name` is not string');
        }
        if (!$this->has($name)) {
            throw new \RuntimeException('item is not found');
        }
        return $this->items[$name];
    }

    public function fetch($name, ItemInterface $item = null)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('`name` is not string');
        }
        if (!$this->has($name)) {
            if ($item === null) {
                $item = new Item();
            }
            $this->push($name, $item);
        }
        return $this->items[$name];
    }

    public function push($name, ItemInterface $item)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('`name` is not string');
        }
        $this->items[$name] = $item;
        return $this->items[$name];
    }

    public function has($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('`name` is not string');
        }
        return array_key_exists($name, $this->items);
    }

    public function getIterator(callable $sort = null)
    {
        if ($sort === null) {
            $sort = function (ItemInterface $a, ItemInterface $b) {
                return $a->prio() - $b->prio();
            };
        }
        $itr = new \ArrayIterator($this->items);
        $itr->uasort($sort);
        $itr->rewind();
        return $itr;
    }

    public function count()
    {
        return count($this->items);
    }
}
