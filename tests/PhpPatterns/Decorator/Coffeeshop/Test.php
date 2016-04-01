<?php

namespace PhpPatterns\Decorator\Coffeeshop;

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

        echo 'Total cost: ' . $teaWithMilkAndLemon->cost();

        $this->assertEquals(Tea::COST + Milk::COST + Lemon::COST, $teaWithMilkAndLemon->cost());
    }

    public function testOrderCoffee()
    {
        //TODO
    }
}
