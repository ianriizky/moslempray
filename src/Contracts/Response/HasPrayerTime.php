<?php

namespace Ianrizky\MoslemPray\Contracts\Response;

use Illuminate\Support\Carbon;

interface HasPrayerTime extends Responsable
{
    /**
     * Return "imsak" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getImsak(): Carbon;

    /**
     * Return "subuh" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getSubuh(): Carbon;

    /**
     * Return "sunrise" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getSunrise(): Carbon;

    /**
     * Return "dhuha" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getDhuha(): Carbon;

    /**
     * Return "dzuhur" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getDzuhur(): Carbon;

    /**
     * Return "ashar" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getAshar(): Carbon;

    /**
     * Return "maghrib" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getMaghrib(): Carbon;

    /**
     * Return "isya" attribute value.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getIsya(): Carbon;

    /**
     * Get the collection of attribute as a plain array.
     *
     * @return array
     */
    public function toArray(): array;
}
