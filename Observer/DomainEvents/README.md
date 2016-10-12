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

