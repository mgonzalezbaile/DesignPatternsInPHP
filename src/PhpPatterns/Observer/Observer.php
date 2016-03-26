<?php

namespace PhpPatterns\Observer;

interface Observer
{
    /**
     * @param Notification $notification
     */
    public function handleNotification(Notification $notification);
}
