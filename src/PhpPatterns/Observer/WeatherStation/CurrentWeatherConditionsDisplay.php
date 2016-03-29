<?php

namespace PhpPatterns\Observer\WeatherStation;

use PhpPatterns\Observer\Notification;
use PhpPatterns\Observer\Observer;

class CurrentWeatherConditionsDisplay implements Observer
{
    /**
     * @param Notification|WeatherInfoWasUpdated $notification
     */
    public function handleNotification(Notification $notification)
    {
        print "#######################\n";
        print 'Current conditions are:'."\n";
        print 'Humidity: '.$notification->humidity()."\n";
        print 'Pressure: '.$notification->pressure()."\n";
        print 'Temperature: '.$notification->temperature()."\n";
    }

    /**
     * @param Notification $notification
     * @return bool
     */
    public function isSubscribedTo(Notification $notification)
    {
        return $notification instanceof WeatherInfoWasUpdated;
    }
}
