<?php

use PhpPatterns\Decorator\CoffeeShop\Coffee;
use PhpPatterns\Decorator\CoffeeShop\Lemon;
use PhpPatterns\Decorator\CoffeeShop\Milk;
use PhpPatterns\Decorator\CoffeeShop\Sugar;
use PhpPatterns\Decorator\CoffeeShop\Tea;

class OrderBeveragesTest extends \PHPUnit_Framework_TestCase
{
    public function testOrderTea()
    {
        /**
         * Product $tea
         */
        $tea = new Tea();

        $teaWithMilk = new Milk($tea);
        $teaWithMilkAndLemon = new Lemon($teaWithMilk);

        echo 'Total cost: '.$teaWithMilkAndLemon->cost();

        $this->assertEquals(Tea::COST + Milk::COST + Lemon::COST, $teaWithMilkAndLemon->cost());
    }

    public function testOrderCoffee()
    {
        /**
         *  Product $coffee
         */
        $coffee = new Coffee();

        $coffeeWithMilk = new Milk($coffee);
        $coffeeWithMilkAndSugar = new Sugar($coffeeWithMilk);

        echo 'Total cost: '.$coffeeWithMilkAndSugar->cost();

        $this->assertEquals(Coffee::COST + Milk::COST + Sugar::COST, $coffeeWithMilkAndSugar->cost());
    }
}
