<?php

namespace PhpPatterns\Observer;

interface Subject
{
    /**
     * @param Observer $observer
     */
    public function registerObserver(Observer $observer);

    /**
     * @param Observer $observer
     */
    public function unregisterObserver(Observer $observer);

    public function notifyObservers();
}
