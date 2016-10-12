<?php

namespace PhpPatterns\Observer\DomainEvents;

use PhpPatterns\Observer\Notification;
use PhpPatterns\Observer\Observer;

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
