<?php

namespace Ianrizky\MoslemPray\Contracts;

use Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime;
use Ianrizky\MoslemPray\Contracts\Response\HasPrayerTimeCollection;

interface Driverable
{
    /**
     * Return prayer time based on the given city and date.
     *
     * @param  mixed  $city
     * @param  \Illuminate\Support\Carbon|string|null  $date
     * @return \Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime
     */
    public function getPrayerTime($city, $date = null): HasPrayerTime;

    /**
     * Return list of prayer time based on the given city and month.
     *
     * @param  mixed  $city
     * @param  \Illuminate\Support\Carbon|string|int|null  $year
     * @param  int|null  $month
     * @return \Ianrizky\MoslemPray\Contracts\Response\HasPrayerTimeCollection
     */
    public function getPrayerTimePerMonth($city, $year = null, int $month = null): HasPrayerTimeCollection;
}
