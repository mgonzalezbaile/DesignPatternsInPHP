# PhpPatterns

You will find here some design patterns implemented with PHP.

Each pattern contains a skeleton with the main classes and interfaces the pattern contains along with some examples using the pattern.

## Observer Pattern
[Observer pattern](https://github.com/mgonzalezbaile/PhpPatterns/tree/master/src/PhpPatterns/Observer) defines a one-to-many dependency between objects so that when one object changes state ([Subject](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/src/PhpPatterns/Observer/Subject.php#L4)), all its dependents ([Observers](https://github.com/mgonzalezbaile/PhpPatterns/blob/master/src/PhpPatterns/Observer/Observer.php)) are notified and updated automatically.

### Weather Station
The first example which shows how to use this pattern is took from the book [Head First Design Patterns](http://shop.oreilly.com/product/9780596007126.do). In the example there is a company asking us to build a set of displays that are able to show different measurements (humidity, pressure, temperature, ...). Those displays are connected to a sensor which is in charge of measuring and then calling the method `changeWeatherData` with the updated info. When that method is called the different displays have to show the new incoming data.
