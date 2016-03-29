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
     * @var WeatherInfo
     */
    private $weatherInfo;

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
            $observer->handleNotification($this->weatherInfo);
        }
    }

    /**
     * @param WeatherInfo $newWeatherInfo
     */
    public function changeWeatherData(WeatherInfo $newWeatherInfo)
    {
        $this->weatherInfo = $newWeatherInfo;
        $this->notifyObservers();
    }
}
