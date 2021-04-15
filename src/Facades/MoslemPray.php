<?php

namespace Ianrizky\MoslemPray\Facades;

use Ianrizky\MoslemPray\Manager;
use Ianrizky\MoslemPray\MoslemPray as BaseClass;
use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * @method static \Ianrizky\MoslemPray\Drivers\MyQuran myquran() Create an instance of the PrayerTimes driver.
 * @method static \Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime getPrayerTime(mixed $city, \Illuminate\Support\Carbon|string|null $date = null) Return prayer time based on the given city and date.
 * @method static \Ianrizky\MoslemPray\Contracts\Response\HasPrayerTimeCollection getPrayerTimePerMonth(mixed $city, \Illuminate\Support\Carbon|string|int|null $year = null, int|null $month = null) Return list of prayer time based on the given city and month.
 *
 * @see \Ianrizky\MoslemPray\Manager
 */
class MoslemPray extends BaseFacade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return Manager::class;
    }

    /**
     * {@inheritDoc}
     */
    public static function getFacadeRoot(): Manager
    {
        return parent::getFacadeRoot();
    }

    /**
     * {@inheritDoc}
     */
    public static function __callStatic($method, $args)
    {
        if (BaseClass::isDriverAvailable($method)) {
            return static::getFacadeRoot()->driver($method);
        }

        return parent::__callStatic($method, $args);
    }
}
