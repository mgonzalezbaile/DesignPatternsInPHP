## Observer Pattern
Observer pattern defines a one-to-many dependency between objects so that when one object changes state (Subject), all its dependents (Observers) are notified and updated automatically.

Observer is one of the best patterns to implement classes that interact each other in a decoupled way. On one hand the Subject only knows that when something important happens to her she must notify the observers, but she does not know anything about what the observers do with the notification. On the other hand, the observers don't know what is going on in the subject until they get notified to perform some action with the incoming info.

### Problem Scenario

We frequently face the kind of scenarios where our business rules say something like:

> If some action occurred on a certain subject, then another action/modification must happen.

This problem can be easily solved by having a procedural function that after performing the requested subject's behavior it carries out something else:

```
public function changeUserPasswordAndNotify(User $user, $newPassword)
{
    $user->changePassword($newPassword);
    $emailService = new EmailService();
    $emailService->send(new Email($user->email(), 'Password changed successfully'));
}
```

In the previous example business wants us to send an email to the user that has changed her password. What problems can we find in that code?:

1. We are breaking the Single Responsibility Principle as we have two different behaviors in the `changeUserPasswordAndNotify` method, one to change the password and another one to notify the user. So if any change is requested to some of both operations we will need to modify the same class, while one class only should be modified by just one reason.
2. Harder to test. If we want to test the behavior of the class we will need to assert that the new password was correctly set as well as the email got sent.
3. What if later on business wants us to notify the user by sms too? Let's see how the code looks like:

```
public function changeUserPasswordAndNotify(User $user, $newPassword)
{
    $user->changePassword($newPassword);
    $emailService = new EmailService();
    $emailService->send(new Email($user->email(), 'Password changed successfully'));
    $smsService = new SmsService();
    $smsService->send(new Sms($user->phone(), 'Password changed successfully'));
}
```

We have been forced to touch a method that we knew it was already working properly, with the risk to introduce bugs to it. This breaks the Open Closed Principle, that says that you must keep your code open for extension but closed for modification.
Also, now you need to make even more complex the test that you already had to assert that:

1. The password was changed
2. The email was sent
3. The sms was sent

We can keep adding more and more reactions (send email, sms, etc) for a given action (change the password) making our code grow towards infinite.

### How Observer Helps

In the given problem scenario we can notice how the Subject (User) has a state (password) that other parties (EmailService, SmsService) are interested in, so whenever a change is made on it they react accordingly. 

The Observer pattern improves solving the problem by giving the capability to the Subject (User) to subscribe others (EmailService, SmsService) that want to get notified whenever a certain change happens on her state.

```
class User {
    private $password;
    pirvate $observers = [];
    
    public function changePassword($newPassword)
    {
        $this->password = $newPassword;
        $this->notifyObserversAbout(new PasswordChanged());
    }

    public function subscribeObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }
    
    private function notifyObserversAbout(Notification $occurredAction)
    {
        foreach ($this->observers as $observer) {
            if ($observer->isSubscribedTo($occurredAction)) {
                $observer->handleNotification($occurredAction);
            }
        }
    }
}
```

Now we can have the observer listening to the PasswordChanged action:

```
class UserPasswordChangesNotifier {
    public function handleNotification(Notification $notification)
    {
        $emailService = new EmailService();
        $emailService->send(new Email($user->email(), 'Password changed successfully'));
        $smsService = new SmsService();
        $smsService->send(new Sms($user->phone(), 'Password changed successfully'));
    }


    public function isSubscribedTo(Notification $notification)
    {
        return $notification instanceof PasswordChanged;
    }
}
```

Or even better if we split the Notifier class into the different delivery means:

```
class UserPasswordChangesEmailNotifier {
    public function handleNotification(Notification $notification)
    {
        $emailService = new EmailService();
        $emailService->send(new Email($user->email(), 'Password changed successfully'));
    }


    public function isSubscribedTo(Notification $notification)
    {
        return $notification instanceof PasswordChanged;
    }
}
```
```
class UserPasswordChangesSmsNotifier {
    public function handleNotification(Notification $notification)
    {
        $smsService = new SmsService();
        $smsService->send(new Sms($user->phone(), 'Password changed successfully'));
    }


    public function isSubscribedTo(Notification $notification)
    {
        return $notification instanceof PasswordChanged;
    }
}
```

So now every reaction is decoupled from each other making very easy the addition of new behavior without modifying existing classes. Putting all together let's see how the previous procedural code looks:

We need first to set up the User with all the subscribers, a factory class can be responsible for it:

```
class UserFactory {
    public method create()
    {
        $user = new User();
        $user->subscribeObserver(new UserPasswordChangesSmsNotifier);
        $user->subscribeObserver(new UserPasswordChangesEmailNotifier);
        return $user;
    }
}
```

So the procedural method that was in charge of changing the password now looks like this: 

```
public method changeUserPassword(User $user, $newPassword)
{
    $user->changePassword($newPassword);
}
```

### Benefits

So the benefits that we get from applying the Observer pattern are:
1. Single Responsibility Principle. Now each class does just one single action.
2. Open Closed Principle. We can keep adding more behaviour when the password changes without modifying anything but just subscribing one more Observer in the UserFactory class.
3. Unit tests very short and contained. The test of the method `changeUserPassword` only has to assert that the password was changed, and the same applies to the other classes.

### Examples in code

- [WeatherStation](https://github.com/mgonzalezbaile/DesignPatternsInPHP/tree/master/Observer/WeatherStation): Similar to the User example shown here, you can find a full implementation example with some tests to try out the code. 
- [DomainEvents](https://github.com/mgonzalezbaile/DesignPatternsInPHP/tree/master/Observer/DomainEvents): Publisher/Subscriber is a variant from the Observer pattern where the logic to notify is encapsulated in to a Singleton class. Therefore, we avoid adding to the Subject the responsibility to manage subscriptions as well as notifying to others, which makes harder (as we saw with the UserFactory class) to instantiate the Subject.