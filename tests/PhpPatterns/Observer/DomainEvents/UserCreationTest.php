<?php

namespace PhpPatterns\Observer\DomainEvents;

class UserCreationTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateNewUser()
    {
        DomainEventPublisher::instance()->registerObserver(new NewUserWasCreatedEmailNotifier());
        DomainEventPublisher::instance()->registerObserver(new NewUserWasCreatedTrialDaysManager());
        new User();
    }
}
