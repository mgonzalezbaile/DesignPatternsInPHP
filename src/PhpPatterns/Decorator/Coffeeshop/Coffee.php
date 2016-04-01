<?php

namespace PhpPatterns\Decorator\Coffeeshop;

class Coffee implements Product
{
    /**
     * @return int
     */
    public function cost()
    {
        return 37;
    }
}
