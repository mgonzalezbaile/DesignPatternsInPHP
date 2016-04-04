<?php

namespace PhpPatterns\Decorator\CoffeeShop;

abstract class Condiment implements Product
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * Condiment constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return string
     */
    abstract public function description();
}
