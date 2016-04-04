<?php

namespace PhpPatterns\Decorator\CoffeeShop;

class Milk extends Condiment
{
    const COST = 50;

    /**
     * @return string
     */
    public function description()
    {
        return 'Milk';
    }

    public function cost()
    {
        return $this->product->cost() + self::COST;
    }
}
