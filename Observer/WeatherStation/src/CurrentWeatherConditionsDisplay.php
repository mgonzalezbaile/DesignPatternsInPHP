<?php

namespace PhpPatterns\Observer\WeatherStation;

use PhpPatterns\Observer\Notification;
use PhpPatterns\Observer\Observer;

class CurrentWeatherConditionsDisplay implements Observer, DisplayElement
{
    /**
     * @var float
     */
    private $humidity;

    /**
     * @var float
     */
    private $pressure;

    /**
     * @var float
     */
    private $temperature;

    /**
     * @param Notification|WeatherInfoWasUpdated $notification
     */
    public function handleNotification(Notification $notification)
    {
        $this->humidity = $notification->humidity();
        $this->pressure = $notification->pressure();
        $this->temperature = $notification->temperature();

        $this->display();
    }

    /**
     * @param Notification $notification
     * @return bool
     */
    public function isSubscribedTo(Notification $notification)
    {
        return $notification instanceof WeatherInfoWasUpdated;
    }

    /**
     * @return void
     */
    public function display()
    {
        print "#######################\n";
        print 'Current conditions are:'."\n";
        print 'Humidity: '.$this->humidity."\n";
        print 'Pressure: '.$this->pressure."\n";
        print 'Temperature: '.$this->temperature."\n";
    }
}
