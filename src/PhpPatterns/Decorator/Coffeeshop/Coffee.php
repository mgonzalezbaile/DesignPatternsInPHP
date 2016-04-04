<?php

namespace PhpPatterns\Decorator\Coffeeshop;

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
