<?php

namespace PhpPatterns\Decorator\CoffeeShop;

class Coffee implements Buyable
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
