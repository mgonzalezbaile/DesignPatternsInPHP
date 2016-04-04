<?php

namespace PhpPatterns\Observer\DomainEvents;

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
