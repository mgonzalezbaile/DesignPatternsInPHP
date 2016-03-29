<?php

namespace PhpPatterns;

use PhpPatterns\Observer\DomainEvents\DomainEventPublisher;
use PhpPatterns\Observer\DomainEvents\NewUserWasCreated;
use PhpPatterns\Observer\DomainEvents\UserId;

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
