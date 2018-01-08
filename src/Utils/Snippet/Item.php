<?php
namespace jigius\sknife\Utils\Snippet;

class Item implements ItemInterface
{
    const MAX_PRIO = 100;

    private $prio;

    private $prepend;

    private $postpend;

    private $chunks;

    public function __construct()
    {
        $this->prio = self::MAX_PRIO - 1;
        $this->prepend = $this->postpend = "";
        $this->chunks = [];
    }

    public function prio($num = null)
    {
        if ($num === null) {
            return $this->prio;
        }
        if (!is_integer($num)) {
            throw new \InvalidArgumentException('not integer');
        }
        $num = (int)$num;
        $this->prio = min($num, self::MAX_PRIO);
        return $this;
    }

    public function prepend($text = null)
    {
        if ($text === null) {
            return $this->prepend;
        }
        if (!is_string($text)) {
            throw new \InvalidArgumentException('not string');
        }
        $this->prepend = $text;
        return $this;
    }

    public function postpend($text = null)
    {
        if ($text === null) {
            return $this->postpend;
        }
        if (!is_string($text)) {
            throw new \InvalidArgumentException('not string');
        }
        $this->postpend = $text;
        return $this;
    }

    public function count()
    {
        return count($this->chunks);
    }

    public function chunk($text)
    {
        if (!is_string($text)) {
            throw new \InvalidArgumentException('not string');
        }
        $this->chunks[] = $text;
        return $this;
    }

    public function output()
    {
        if ($this->count() == 0) {
            return "";
        }
        return implode(
            "\r\n",
            array_merge(
                [$this->prepend()],
                $this->chunks,
                [$this->postpend()]
            )
        );
    }
}
