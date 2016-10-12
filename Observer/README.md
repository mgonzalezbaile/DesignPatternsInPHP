## Observer Pattern
Observer pattern defines a one-to-many dependency between objects so that when one object changes state (Subject), all its dependents (Observers) are notified and updated automatically.

This pattern allows to create classes that interact each other in a deocupled way. On one hand the Subject only knows that when something important happens she must notify the observers, but she does not know anything about what the observers do with the notification. On the other hand, the observers don't know what is going on in the subject until they get notified and perform some action with the incoming info.

![image](https://cloud.githubusercontent.com/assets/1727504/14110752/6379f37c-f5b7-11e5-930b-91c8f4992a92.png)
