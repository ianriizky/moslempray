<?php

namespace Ianrizky\MoslemPray\Contracts;

use Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime;

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
}
