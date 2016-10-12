<?php

namespace PhpPatterns\Observer\DomainEvents;

use PhpPatterns\Observer\Notification;
use PhpPatterns\Observer\Observer;

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
