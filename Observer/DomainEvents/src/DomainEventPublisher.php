<?php

namespace PhpPatterns\Observer\DomainEvents;

use PhpPatterns\Observer\Notification;
use PhpPatterns\Observer\Observer;
use PhpPatterns\Observer\Subject;

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

    public function __clone()
    {
        throw new \BadMethodCallException('Clone is not supported');
    }

    /**
     * @param Observer $observer
     */
    public function registerObserver(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * @param Observer $observer
     */
    public function unregisterObserver(Observer $observer)
    {
        for ($i = 0; $i < count($this->observers); $i++) {
            if ($this->observers[$i] === $observer) {
                unset($this->observers[$i]);
                $this->observers = array_values($this->observers);
            }
        }
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
