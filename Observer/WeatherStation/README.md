# Weather Station
This example comes from the book [Head First Design Patterns](http://shop.oreilly.com/product/9780596007126.do). 

## Use Case
In the example there is a company asking us to build a set of displays showing different weather measurements (humidity, pressure, temperature, ...). Those displays take the weather info from a [Weather Station](https://github.com/mgonzalezbaile/PhpPatterns/tree/master/src/PhpPatterns/Observer/WeatherStation) which consists of different [sensors](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/tests/PhpPatterns/Observer/WeatherStation/WeatherSensorsTest.php) that are in charge of measuring and notifying the weather info to the Weather Station. When sensors push new data to the Weather Station the [CurrentWeatherConditionsDisplay](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/src/PhpPatterns/Observer/WeatherStation/CurrentWeatherConditionsDisplay.php) and [WeatherStatisticsDisplay](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/src/PhpPatterns/Observer/WeatherStation/WeatherStatisticsDisplay.php) have to show the new incoming data.

As you can see here our Subject is the weather Station and its state (the weather info) can be changed by the sensors at any time. On the other side the displays are the Observers and they want to be notified every time the weather info is updated to show the new data.

## UML

![image](https://cloud.githubusercontent.com/assets/1727504/14111669/245a0e44-f5bb-11e5-8374-8d719ab36f66.png)
