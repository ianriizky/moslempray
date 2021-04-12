<?php

namespace Ianrizky\MoslemPray\Contracts\Response;

use Ianrizky\MoslemPray\Contracts\Responsable;
use Illuminate\Support\Carbon;

interface HasPrayerTime extends Responsable
{
    /**
     * Return "imsak" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getImsak();

    /**
     * Return "subuh" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getSubuh();

    /**
     * Return "sunrise" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getSunrise();

    /**
     * Return "dhuha" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getDhuha();

    /**
     * Return "dzuhur" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getDzuhur();

    /**
     * Return "ashar" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getAshar();

    /**
     * Return "maghrib" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getMaghrib();

    /**
     * Return "isya" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getIsya();

    /**
     * Get the collection of attribute as a plain array.
     *
     * @return array
     */
    public function toArray();
}
