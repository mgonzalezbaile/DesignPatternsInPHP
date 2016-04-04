<?php

namespace PhpPatterns\Decorator\Coffeeshop;

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
        return $this->product->cost() + self::COST;
    }
}
