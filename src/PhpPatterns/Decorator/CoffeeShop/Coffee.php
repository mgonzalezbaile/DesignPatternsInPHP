<?php

namespace PhpPatterns\Decorator\CoffeeShop;

class Coffee implements Product
{
    const COST = 37;

    /**
     * @return int
     */
    public function cost()
    {
        return self::COST;
    }
}
