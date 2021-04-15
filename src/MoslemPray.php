<?php

namespace Ianrizky\MoslemPray;

use Ianrizky\MoslemPray\Drivers\AbstractDriver;
use Ianrizky\MoslemPray\Drivers\MyQuran;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\ForwardsCalls;
use InvalidArgumentException;

/**
 * @method static \Ianrizky\MoslemPray\Drivers\MyQuran myquran(array $config = []) Create an instance of the PrayerTimes driver.
 * @method static \Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime getPrayerTime(mixed $city, \Illuminate\Support\Carbon|string|null $date) Return prayer time based on the given city and date.
 * @method static \Ianrizky\MoslemPray\Contracts\Response\HasPrayerTimeCollection getPrayerTimePerMonth(mixed $city, \Illuminate\Support\Carbon|string|int|null $year = null, int|null $month = null) Return list of prayer time based on the given city and month.
 *
 * @see \Ianrizky\MoslemPray\Contracts\Driverable
 */
class MoslemPray
{
    use ForwardsCalls;

    /**
     * Driver instance object.
     *
     * @var \Ianrizky\MoslemPray\Drivers\AbstractDriver
     */
    protected $driver;

    /**
     * List of available driver name.
     *
     * @var array
     */
    public const DRIVERS = [
        'myquran' => MyQuran::class,
    ];

    /**
     * Default driver class name.
     *
     * @var string
     */
    public static $defaultDriverName = 'myquran';

    /**
     * Create a new instance class.
     *
     * @param  string|array|null  $driverName
     * @param  array  $config
     * @return void
     */
    public function __construct($driverName = null, array $config = [])
    {
        if (is_array($driverName)) {
            $driverName = $this->getDriverNameFromConfig($driverName);

            $config = Arr::except($config, 'driver');
        } elseif (is_null($driverName)) {
            $driverName = static::$defaultDriverName;
        }

        $this->driver = static::createDriverInstance($driverName, $config);
    }

    /**
     * Return driver name value from given config.
     *
     * @param  array  $config
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function getDriverNameFromConfig(array $config): string
    {
        $driverName = $config['driver'] ?? null;

        if (!static::isDriverAvailable($driverName)) {
            throw new InvalidArgumentException('Driver name is unidentified');
        }

        return $driverName;
    }

    /**
     * Determine whether the given driver name is available or not.
     *
     * @param  string  $name
     * @return bool
     */
    public static function isDriverAvailable(string $name): bool
    {
        return in_array($name, array_keys(static::DRIVERS), true);
    }

    /**
     * Create driver instance based on given driver name.
     *
     * @param  string  $driverName
     * @param  array  $config
     * @return \Ianrizky\MoslemPray\Drivers\AbstractDriver
     *
     * @throws \InvalidArgumentException
     */
    public static function createDriverInstance(string $driverName, array $config = []): AbstractDriver
    {
        if (static::isDriverAvailable($driverName)) {
            $driver = static::DRIVERS[$driverName];

            return new $driver($config);
        }

        throw new InvalidArgumentException("Driver [$driverName] is not supported.");
    }

    /**
     * Dynamically handle calls to the class.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (static::isDriverAvailable($method)) {
            return static::createDriverInstance($method, ...$parameters);
        }

        return $this->forwardCallTo($this->driver, $method, $parameters);
    }

    /**
     * Dynamically handle static calls to the class.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->{$method}(...$parameters);
    }
}
