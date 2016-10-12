<?php

namespace PhpPatterns\Observer\DomainEvents;

use PhpPatterns\Observer\Notification;

class NewUserWasCreated implements Notification
{
    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    private $userId;

    /**
     * NewUserWasCreated constructor.
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->occurredOn = new \DateTimeImmutable();
        $this->userId = $userId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        return $this->userId;
    }
}
