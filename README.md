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


