<?php

namespace PhpPatterns\Observer\WeatherStation;

use PhpPatterns\Observer\Notification;
use PhpPatterns\Observer\Observer;

class WeatherStatisticsDisplay implements Observer, DisplayElement
{
    /**
     * @var WeatherMeasurementCollection
     */
    private $humidityMeasurements;

    /**
     * @var WeatherMeasurementCollection
     */
    private $pressureMeasurements;

    /**
     * @var WeatherMeasurementCollection
     */
    private $temperatureMeasurements;

    /**
     * WeatherStatisticsDisplay constructor.
     */
    public function __construct()
    {
        $this->humidityMeasurements = WeatherMeasurementCollection::fromMeasurements([]);
        $this->pressureMeasurements = WeatherMeasurementCollection::fromMeasurements([]);
        $this->temperatureMeasurements = WeatherMeasurementCollection::fromMeasurements([]);
    }

    /**
     * @param Notification|WeatherInfoWasUpdated $notification
     */
    public function handleNotification(Notification $notification)
    {
        $this->humidityMeasurements = $this->humidityMeasurements->add($notification->humidity());
        $this->pressureMeasurements = $this->pressureMeasurements->add($notification->pressure());
        $this->temperatureMeasurements = $this->temperatureMeasurements->add($notification->temperature());

        $this->display();
    }

    /**
     * @return void
     */
    public function display()
    {
        print "#######################\n";
        print 'Statistics:'."\n";
        print 'Humidity: '.$this->humidityMeasurements."\n";
        print 'Pressure: '.$this->pressureMeasurements."\n";
        print 'Temperature: '.$this->temperatureMeasurements."\n";
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
