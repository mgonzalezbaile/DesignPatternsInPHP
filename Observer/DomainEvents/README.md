# Domain Events

## Definition
`Domain Event` is a very important concept in [Domain Driven Design](https://en.wikipedia.org/wiki/Domain-driven_design) that defines something that has happened in the past. Based on the Publisher/Subscriber pattern they provide the perfect approach to make code in a decoupled way.

![image](https://cloud.githubusercontent.com/assets/1727504/19317428/4888a52a-90a5-11e6-86aa-abead6a3e197.png)

Domain Events capture information from an external stimulus (what happened) and probably the changes on the state of some Entity due to the stimulus so you can see what happened and the changes at any moment. Domain Events are frequently defined by domain experts when they explain the behavior of the system, for instance: 

> Whenever a new user is created into the platform the customer department must be notified by email.

We can see in the sentence that we are performing some action (user creation) so after it happened something else has to be done (notification). The Domain Event is `UserCreated` and some info it can hold is the name of the user, the email, etc.

So far, everything looks exactly the same as what is explained in the [Observer pattern section](https://github.com/mgonzalezbaile/DesignPatternsInPHP/tree/master/Observer) and [Weather Station example](https://github.com/mgonzalezbaile/DesignPatternsInPHP/tree/master/Observer/WeatherStation). The difference is more about the implementation.

In this case, the pattern implementation defined in DDD follows the Singleton Pattern in the form of a generic Publisher in charge of managing the register of subscribers as well as the delivery of the events to them. In this way we avoid polluting our Subject entities with methods (subscribe, notify, ...) that nothing has to do with business behavior. 

```
class DomainEventPublisher implements Subject
{
    /**
     * @var Observer[]
     */
    private $observers;

    /**
     * @var self
     */
    private static $instance = null;

    /**
     * @var Notification
     */
    private $domainEvent;

    /**
     * @return self
     */
    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * DomainEventPublisher constructor.
     */
    private function __construct()
    {
        $this->observers = [];
    }

    /**
     * @param Observer $observer
     */
    public function registerObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function notifyObservers()
    {
        foreach ($this->observers as $observer) {
            if ($observer->isSubscribedTo($this->domainEvent)) {
                $observer->handleNotification($this->domainEvent);
            }
        }
    }

    /**
     * @param Notification $domainEvent
     */
    public function publish(Notification $domainEvent)
    {
        $this->domainEvent = $domainEvent;
        $this->notifyObservers();
    }
}
```

## Use Case

To see how Domain Events work in code let's consider the next use case:

> Whenever a new User is created in the system, we must notify him via email and start a 15 trial period.

Thanks to the `DomainEventPublisher` now the `User` class does not need to implement the methods to notify/subscribe others and it can be focused on just business behavior and invariants:

```
class User
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->userId = new UserId();

        DomainEventPublisher::instance()->publish(new NewUserWasCreated($this->userId));
    }
}
```

We are publishing the domain event `NewUserWasCreated` when the user is created. Now we need to notify the user and give her a 15 days trial period:

```
class NewUserWasCreatedEmailNotifier implements Observer
{
    /**
     * @param Notification|NewUserWasCreated $notification
     */
    public function handleNotification(Notification $notification)
    {
        echo 'Sending an email to customer department for the user: '.$notification->userId()."\n";
    }

    /**
     * @param Notification $notification
     * @return bool
     */
    public function isSubscribedTo(Notification $notification)
    {
        return $notification instanceof NewUserWasCreated;
    }
}
```

```
class NewUserWasCreatedTrialDaysManager implements Observer
{
    /**
     * @param Notification|NewUserWasCreated $notification
     */
    public function handleNotification(Notification $notification)
    {
        echo 'Giving 15 trial days to the user: '.$notification->userId()."\n";
    }

    /**
     * @param Notification $notification
     * @return bool
     */
    public function isSubscribedTo(Notification $notification)
    {
        return $notification instanceof NewUserWasCreated;
    }
}
```

The code of the Subscribers (`NewUserWasCreatedEmailNotifier` and `NewUserWasCreatedTrialDaysManager`) is exactly the same than the Observers from [Observer pattern section](https://github.com/mgonzalezbaile/DesignPatternsInPHP/tree/master/Observer). The last step is to bind the subscribers with the publisher, in web applications this occurs in the entry point file (index.php):

```
DomainEventPublisher::instance()->registerObserver(new NewUserWasCreatedEmailNotifier());
DomainEventPublisher::instance()->registerObserver(new NewUserWasCreatedTrialDaysManager());
```

Therefore we don't need to make the instantiation of an User complex like it happened in the example given in the [Observer pattern section](https://github.com/mgonzalezbaile/DesignPatternsInPHP/tree/master/Observer) where a factory was required.

## UML

![image](https://cloud.githubusercontent.com/assets/1727504/14114274/e0afe050-f5c5-11e5-98ca-603f4ed4e24e.png)


