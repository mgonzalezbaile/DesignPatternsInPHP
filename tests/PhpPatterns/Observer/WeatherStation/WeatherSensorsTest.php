<?php

namespace PhpPatterns\Observer\WeatherStation;

/**
 * This class emulates the sensors that measure the weather conditions and update the Weather Station state
 * Class WeatherStationTest
 * @package PhpPatterns\Observer\WeatherStation
 */
class WeatherSensorsTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  Current conditions and weather statistics are displayed
     */
    public function testDisplayWeatherInfo()
    {
        $currentWeatherConditionsDisplay = new CurrentWeatherConditionsDisplay();
        $weatherStatisticsDisplay = new WeatherStatisticsDisplay();
        $weatherStation = new WeatherStation();
        $weatherStation->registerObserver($currentWeatherConditionsDisplay);
        $weatherStation->registerObserver($weatherStatisticsDisplay);

        $weatherStation->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
        $weatherStation->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
        $weatherStation->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
        $weatherStation->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
    }

    /**
     *  No data is displayed
     */
    public function testUnregisterObserver()
    {
        $currentWeatherConditionsDisplay = new CurrentWeatherConditionsDisplay();
        $weatherStation = new WeatherStation();
        $weatherStation->registerObserver($currentWeatherConditionsDisplay);
        $weatherStation->unregisterObserver($currentWeatherConditionsDisplay);
        $weatherStation->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
    }
}
