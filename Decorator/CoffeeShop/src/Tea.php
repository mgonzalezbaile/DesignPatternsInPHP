<?php

namespace PhpPatterns\Decorator\CoffeeShop;

class Tea implements Buyable
{
    const COST = 15;

    /**
     * @return int
     */
    public function cost()
    {
        return self::COST;
    }
}
