<?php

namespace PhpPatterns\Observer\WeatherStation;

use PhpPatterns\Observer\Notification;

class WeatherInfo implements Notification
{
    /**
     * @var float
     */
    private $humidity;

    /**
     * @var float
     */
    private $temperature;

    /**
     * @var float
     */
    private $pressure;

    /**
     * WeatherInfo constructor.
     * @param float $humidity
     * @param float $temperature
     * @param float $pressure
     */
    public function __construct($humidity, $temperature, $pressure)
    {
        $this->humidity = $humidity;
        $this->temperature = $temperature;
        $this->pressure = $pressure;
    }

    /**
     * @return float
     */
    public function humidity()
    {
        return $this->humidity;
    }

    /**
     * @return float
     */
    public function temperature()
    {
        return $this->temperature;
    }

    /**
     * @return float
     */
    public function pressure()
    {
        return $this->pressure;
    }
}
