# PhpPatterns

You will find here some design patterns implemented with PHP.

Each pattern contains a skeleton with the main classes and interfaces the pattern contains along with some examples using the pattern. Also a test is provided in order to run some examples to see how the pattern works.

## Observer Pattern
[Observer pattern](https://github.com/mgonzalezbaile/PhpPatterns/tree/master/src/PhpPatterns/Observer) defines a one-to-many dependency between objects so that when one object changes state ([Subject](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/src/PhpPatterns/Observer/Subject.php#L4)), all its dependents ([Observers](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/src/PhpPatterns/Observer/Observer.php)) are notified and updated automatically.

This pattern allows to create classes that interact each other in a deocupled way. On one hand the Subject only knows that when something important happens she must notify the observers, but she does not know anything about what the observers do with the notification. On the other hand, the observers don't know what is going on in the subject until they get notified and perform some action with the incoming info.

![image](https://cloud.githubusercontent.com/assets/1727504/14110752/6379f37c-f5b7-11e5-930b-91c8f4992a92.png)

### Weather Station
The first example, which shows how to use this pattern, is took from the book [Head First Design Patterns](http://shop.oreilly.com/product/9780596007126.do). In the example there is a company asking us to build a set of displays that are able to show different weather measurements (humidity, pressure, temperature, ...). Those displays take the weather info from a [Weather Station](https://github.com/mgonzalezbaile/PhpPatterns/tree/master/src/PhpPatterns/Observer/WeatherStation) which consists of many [sensors](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/tests/PhpPatterns/Observer/WeatherStation/WeatherSensorsTest.php) that are in charge of measuring and then calling the method `changeWeatherData` of the weather Station with the updated info. When that method is called the different displays ([CurrentWeatherConditionsDisplay](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/src/PhpPatterns/Observer/WeatherStation/CurrentWeatherConditionsDisplay.php) and [WeatherStatisticsDisplay](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/src/PhpPatterns/Observer/WeatherStation/WeatherStatisticsDisplay.php)) have to show the new incoming data.

As you can see here our Subject is the weather Station and its state (the weather info) can be changed by the sensors at any time. On the other side the displays are the Observers and they want to be notified every time the weather info is updated to show the new data.

![image](https://cloud.githubusercontent.com/assets/1727504/14111669/245a0e44-f5bb-11e5-8374-8d719ab36f66.png)


### Domain Events
`Domain Event` is a very important concept in [Domain Driven Design](https://en.wikipedia.org/wiki/Domain-driven_design). They provide a good approach to apply rules that are important for your business in a decoupled way.

Let's explain them with an example. Imagine that business says: 

> Whenever a new user is created into the platform the customer department must be notified by email.

Ok, that's easy. I can create a service that registers a new user and sends an email to that department. But imagine that two months later business comes to you and say:

> Now, in addition to send the email I want you to give to the user a 15 trial days to use the brand new tool that we released last week.

Ok, easy too. You go to the service that is in charge of creating the user and adds the new business logic requested.

As you can see, every time business wants to perform a new action when a new user is created you need to go to the same service and apply the pertinent modifications. We are breaking the [Open Closed Principle](https://en.wikipedia.org/wiki/Open/closed_principle).

Observer Pattern to the rescue! Again we can apply the Observer pattern to decouple an action on the Subject from the business rules that must be satisfied when that action happens. We only need to implement those rules in different observers (one in charge of sending emails, another one to give the trial days, etc) so they will be notified when a new user is created in the same way we did in the Weather Station example.

In this example you can see that the Subject is not the User itself but a generic Publisher class instead. The reason is that we can make use of a more generic class in charge of publishing the event and reuse it for any kind of event we want to publish.

![image](https://cloud.githubusercontent.com/assets/1727504/14114274/e0afe050-f5c5-11e5-98ca-603f4ed4e24e.png)

If in the future business asks us to perform a new action when a new user is created, we will only need to create a new Observer doing that functionality. As you can see no modifications on existing classes would be needed.

## Decorator Pattern
`The Decorator Pattern` attaches additional responsibilities to an object dynamically. Decorators provide a flexible alternative to subclassing for extending functionality.

There is kind of a rule of thumb that says **favor composition over inheritance**. While inheritance is a powerful tool that OOP languages have to avoid repeating code and inherit it from a parent class instead, many times is not the best way to create a flexible sytem.
 
When we are inheriting behavior from another class, we are forcing the subclasses to have that behavior or override it if needed. This can lead us to a rigid hierarchy of classes that can become impossible to extend in the future. There is a good article explaining the problems related to this topic [here](https://codingdelight.com/2014/01/16/favor-composition-over-inheritance-part-1/).

Having that rule in mind, the `Decorator Pattern` helps a lot on creating designs favoring composition. Let's see some examples to understand the pattern.
 
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
    