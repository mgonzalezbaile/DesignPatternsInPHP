<?php

namespace PhpPatterns\Observer\WeatherStation;

class WeatherStationTest extends \PHPUnit_Framework_TestCase
{
    /**
     *  Current conditions and statistics weather are displayed
     */
    public function testShowCurrentConditions()
    {
        $currentWeatherConditionsDisplay = new CurrentWeatherConditionsDisplay();
        $weatherStatisticsDisplay = new WeatherStatisticsDisplay();
        $weatherData = new WeatherData();
        $weatherData->registerObserver($currentWeatherConditionsDisplay);
        $weatherData->registerObserver($weatherStatisticsDisplay);

        $weatherData->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
        $weatherData->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
        $weatherData->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
        $weatherData->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
    }

    /**
     *  No data is displayed
     */
    public function testUnregisterObserver()
    {
        $currentWeatherConditionsDisplay = new CurrentWeatherConditionsDisplay();
        $weatherData = new WeatherData();
        $weatherData->registerObserver($currentWeatherConditionsDisplay);
        $weatherData->unregisterObserver($currentWeatherConditionsDisplay);
        $weatherData->changeWeatherData(
            new WeatherInfo(floatval(rand(0, 100)), floatval(rand(0, 100)), floatval(rand(0, 100)))
        );
    }
}
