<?php

namespace Ianrizky\MoslemPray\Support;

use Illuminate\Support\Carbon;
use InvalidArgumentException;

trait ParseDate
{
    /**
     * Parse the given date into a Carbon instance.
     *
     * @param  mixed  $date
     * @return \Illuminate\Support\Carbon
     *
     * @throws \InvalidArgumentException
     */
    protected static function parseDate($date): Carbon
    {
        if ($date instanceof Carbon) {
            return $date;
        }

        if (is_string($date)) {
            return Carbon::parse($date);
        }

        if (is_null($date)) {
            return Carbon::today();
        }

        throw new InvalidArgumentException(sprintf(
            'Parameter $date must be a string or %s instance. %s given.',
            Carbon::class, is_object($date) ? get_class($date) : gettype($date)
        ));
    }
}
