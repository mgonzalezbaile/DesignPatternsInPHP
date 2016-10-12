### The Coffee Shop
Imagine that there is a coffee shop asking us to create a system that will allow them to manage their beverages and condiments.

At the moment, they only have two types of beverages: coffee and tea, along with a set of condiments the customer can put on top: lemon, milk and sugar. However, the owner of the coffee shop already knows that there will be more beverages and condiments in the future so he also wants a system that allows to add new products easily. 

They system should be able to manage their different costs and calculate the result when the customer orders a beverage with some condiments.

Looking towards inheritance we could say that we have a base class `Product` with a cost associated, and then each subclass (the different beverages and condiments) can implement their own cost.
 
    abstract class Product
    {
        abstract public function cost();
    }

    class Coffee extends Product
    {
        public function cost()
        {
            return 15; //The price of the cofee in cents
        }
    }

    class Tea extends Product
    {
        public function cost()
        {
            return 10; //The price of the tea in cents
        }
    }

    class ProductTest
    {
        public function testCost()
        {
            $coffee = new Coffee();
            $tea = new Tea();
            
            echo 'The price of the coffee is: ' . $this->calculateCost($coffee);
            echo 'The price of the tea is: ' . $this->calculateCost($tea);
        }
        
        private function calculateCost(Product $product)
        {
            return $product->cost();
        }
    }

So far so good, thinking that a beverage **is-a** `Product` allows us to think only in one element. See the `calculateCost` and notice how he does not care about which type of product you are passing as parameter.
 
Ok, we can also say that a condiment **is-a** `Product` as well with its own price: 

    class Milk extends Product
    {
        public function cost()
        {
            return 10;
        }
    }

We can event start combining beverages and condiments:

    class TeaWithMilk extends Product
    {
        public function cost()
        {
            return 20; //The price of the tea + milk in cents
        }
    }

    class TeaWithMilkWithLemon extends Product
    {
        public function cost()
        {
            return 20; //The price of the tea + milk + lemon in cents
        }
    }

By doing it like above we will end up having an ocean of classes for the different products combination very hard to maintain. What would happen if the tea's price changes? we should go over all our classes where tea is in and perform the change.

#### Composition over inheritance

If we stop thinking that everything **is-a** `Product` but we look at the behavior instead, we can say that all those elements are `Buyable`, that is, a customer can buy a beverage as well as she can buy condiments. Because of it is `Buyable` it needs the cost method. Let's take a look at the code:

    interface Buyable
    {
        public function cost();
    }
            
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

    class Milk implements Buyable
    {
        const COST = 10;
    
        /**
         * @return int
         */
        public function cost()
        {
            return self::COST;
        }
    }

The main change in the code shown above is that Coffee does not `is-a` Product anymore but Coffee `has-a` Buyable behavior instead.

And now is when the **Decorator Pattern** comes in action to combine Coffee and Tea with condiments such as Milk, Lemon, Sugar and so on. What we want to get by using the pattern is something like:

    public function testOrderTea()
    {
        /**
         * Product $tea
         */
        $tea = new Tea();

        $teaWithMilk = new Milk($tea);
        $teaWithMilkAndLemon = new Lemon($teaWithMilk);

        echo 'Total cost: ' . $teaWithMilkAndLemon->cost();
    }

As you can see, the code result is like real life as you first put the Tea, then you put the Milk and then the Lemon, so at the end you want to know the total cost of the result drink. Let's see the changes we need to do in our existing classes then:

    class Lemon implements Buyable
    {
        const COST = 50;
    
        public function __construct(Buyable $buyable)
        {
            $this->buyable = $buyable;
        }

        /**
         * @return string
         */
        public function description()
        {
            return 'Lemon';
        }
    
        public function cost()
        {
            return $this->buyable->cost() + self::COST;
        }
    }

    class Milk implements Buyable
    {
        const COST = 50;
    
        public function __construct(Buyable $buyable)
        {
            $this->buyable = $buyable;
        }

        /**
         * @return string
         */
        public function description()
        {
            return 'Milk';
        }
    
        public function cost()
        {
            return $this->buyable->cost() + self::COST;
        }
    }

We have added a constructor so we can wrap a buyable within other buyable and therefore chain methods in a recursive way like in the case of the `cost`. Now if I wrap my Tea with Milk resulting in a TeaWithMilk object, whenever I ask for the cost of that result I can recursively add the cost of each wrapped element.
 
The most interesting part is that we are creating the TeaWithMilk object (the same we created extending the Product class) but this time everything is done dynamically, we don't need to create hundreds of classes for each combination as we can combine them during the execution of the program. Also, if we want now to change the price of a single condiment or beverage, we don't need to go over all the classes that make use of that condiment as it will be recursively resolved without touching anything. 

If we keep adding more and more condiments we will notice that all of them share same parts of code such us the constructor as well as that we require them to provide a description so we can avoid repeating code by applying inheritance this time:

    abstract class Condiment implements Buyable
    {
        /**
         * @var Buyable
         */
        protected $buyable;
    
        /**
         * Condiment constructor.
         *
         * @param Buyable $buyable
         */
        public function __construct(Buyable $buyable)
        {
            $this->buyable = $buyable;
        }
    
        /**
         * @return string
         */
        abstract public function description();
    }
    
    class Lemon extends Condiment
    {
        const COST = 50;
    
        /**
         * @return string
         */
        public function description()
        {
            return 'Lemon';
        }
    
        public function cost()
        {
            return $this->buyable->cost() + self::COST;
        }
    }
    