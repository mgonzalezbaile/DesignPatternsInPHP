<?php

namespace PhpPatterns\Decorator\Coffeeshop;

class Sugar extends Condiment
{
    /**
     * @return string
     */
    public function description()
    {
        return 'sugar';
    }

    public function cost()
    {
        return $this->product->cost() + 50;
    }
}
