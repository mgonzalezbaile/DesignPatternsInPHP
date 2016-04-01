<?php

namespace PhpPatterns\Decorator\Coffeeshop;

class Tea implements Product
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
