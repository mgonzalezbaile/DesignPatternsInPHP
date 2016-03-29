<?php

namespace PhpPatterns\Observer\WeatherStation;

use PhpPatterns\Observer\Notification;

class WeatherInfoWasUpdated implements Notification
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
     * @var \DateTimeImmutable
     */
    private $occurredOn;

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
        $this->occurredOn = new \DateTimeImmutable();
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

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }
}
