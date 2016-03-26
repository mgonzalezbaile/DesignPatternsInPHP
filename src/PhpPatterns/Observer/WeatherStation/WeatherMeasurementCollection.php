<?php

namespace PhpPatterns\Observer\WeatherStation;

use Assert\Assertion;

class WeatherMeasurementCollection implements \IteratorAggregate
{
    /**
     * @var float[]
     */
    private $measurements;

    /**
     * @var float
     */
    private $min;

    /**
     * @var float
     */
    private $max;

    /**
     * @var float
     */
    private $average;

    /**
     * @param float[] $measurements
     * @return WeatherMeasurementCollection
     */
    public static function fromMeasurements(array $measurements)
    {
        return new self($measurements);
    }

    /**
     * WeatherMeasurementRange constructor.
     * @param float[] $measurements
     */
    private function __construct(array $measurements)
    {
        Assertion::allFloat($measurements);

        if (count($measurements) > 0) {
            $this->min = min($measurements);
            $this->max = max($measurements);
            $this->average = array_sum($measurements) / count($measurements);
        }

        $this->measurements = $measurements;
    }

    /**
     * @return float
     */
    public function min()
    {
        return $this->min;
    }

    /**
     * @return float
     */
    public function max()
    {
        return $this->max;
    }

    /**
     * @return float
     */
    public function average()
    {
        return $this->average;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->measurements);
    }

    /**
     * @param float $measurement
     * @return WeatherMeasurementCollection
     */
    public function add($measurement)
    {
        $this->measurements[] = $measurement;

        return new self($this->measurements);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            'values: %s: min: %s, max: %s, average: %s',
            implode(',', $this->measurements),
            $this->min(),
            $this->max(),
            $this->average()
        );
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return count($this->measurements) === 0;
    }
}
