<?php

namespace PhpPatterns\Observer\WeatherStation;

use PhpPatterns\Observer\Observer;
use PhpPatterns\Observer\Subject;

class WeatherStation implements Subject
{
    /**
     * @var Observer[]
     */
    private $observers = [];

    /**
     * @var WeatherInfoWasUpdated
     */
    private $weatherInfoWasUpdated;

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
            if ($observer->isSubscribedTo($this->weatherInfoWasUpdated)) {
                $observer->handleNotification($this->weatherInfoWasUpdated);
            }
        }
    }

    /**
     * @param WeatherInfoWasUpdated $newWeatherInfo
     */
    public function changeWeatherData(WeatherInfoWasUpdated $newWeatherInfo)
    {
        $this->weatherInfoWasUpdated = $newWeatherInfo;
        $this->notifyObservers();
    }
}
