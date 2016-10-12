## Decorator Pattern
`The Decorator Pattern` attaches additional responsibilities to an object dynamically. Decorators provide a flexible alternative to subclassing for extending functionality.

There is kind of a rule of thumb that says **favor composition over inheritance**. While inheritance is a powerful tool that OOP languages have to avoid repeating code and inherit it from a parent class instead, many times is not the best way to create a flexible sytem.
 
When we are inheriting behavior from another class, we are forcing the subclasses to have that behavior or override it if needed. This can lead us to a rigid hierarchy of classes that can become impossible to extend in the future. There is a good article explaining the problems related to this topic [here](https://codingdelight.com/2014/01/16/favor-composition-over-inheritance-part-1/).

Having that rule in mind, the `Decorator Pattern` helps a lot on creating designs favoring composition. Let's see some examples to understand the pattern.
