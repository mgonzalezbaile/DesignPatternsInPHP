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

![image](https://cloud.githubusercontent.com/assets/1727504/14110840/c274d61c-f5b7-11e5-9a60-22e0a6a0d48b.png)

### Domain Events
`Domain Event` is a very important concept in [Domain Driven Design](https://en.wikipedia.org/wiki/Domain-driven_design). They provide a good approach to apply rules that are important for your business in a decoupled way.

Let's explain them with an example. Imagine that business says: 

> Whenever a new user is created into the platform the customer department must be notified by email.

Ok, that's easy. I can create a service that registers a new user and sends an email to that department. But imagine that two months later business comes to you and say:

> Now, in addition to send the email I want you to give to the user a 15 trial days to use the brand new tool that we released last week.

Ok, easy too. You go to the service that is in charge of creating the user and adds the new business logic requested.

As you can see, every time business wants to perform a new action when a new user is created you need to go to the same service and apply the pertinent modifications. We are breaking the [Open Closed Principle](https://en.wikipedia.org/wiki/Open/closed_principle).

Observer Pattern to the rescue! Again we can apply the Observer pattern to decouple an action on the Subject (the user) from the business rules that must be satisfied when that action happens. We only need to implement those rules in different observers (one in charge of sending emails, another one to give the trial days, etc) so they will be notified when a new user is created in the same way we did in the Weather Station example.