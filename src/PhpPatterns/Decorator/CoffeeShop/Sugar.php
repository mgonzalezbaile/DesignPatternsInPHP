<?php

namespace PhpPatterns\Decorator\CoffeeShop;

class Sugar extends Condiment
{
    const COST = 50;

    /**
     * @return string
     */
    public function description()
    {
        return 'sugar';
    }

    public function cost()
    {
        return $this->buyable->cost() + self::COST;
    }
}
