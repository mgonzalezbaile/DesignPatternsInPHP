<?php

namespace PhpPatterns\Decorator\CoffeeShop;

abstract class Condiment implements Buyable
{
    /**
     * @var Buyable
     */
    protected $buyable;

    /**
     * Condiment constructor.
     *
     * @param Buyable $buyable
     */
    public function __construct(Buyable $buyable)
    {
        $this->buyable = $buyable;
    }

    /**
     * @return string
     */
    abstract public function description();
}
