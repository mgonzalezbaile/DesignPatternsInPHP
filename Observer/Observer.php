<?php

namespace PhpPatterns\Observer;

interface Observer
{
    /**
     * @param Notification $notification
     */
    public function handleNotification(Notification $notification);

    /**
     * @param Notification $notification
     * @return bool
     */
    public function isSubscribedTo(Notification $notification);
}
