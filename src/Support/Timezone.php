<?php

namespace Ianrizky\MoslemPray\Support;

use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

class Timezone
{
    /**
     * Return collection of city with its timezone value.
     *
     * @return \Illuminate\Support\LazyCollection
     */
    public static function collection(): LazyCollection
    {
        return LazyCollection::make(function () {
            $handle = fopen('storage/timezone.ndjson', 'r');

            while (($line = fgets($handle)) !== false) {
                yield json_decode($line, true);
            }
        });
    }

    /**
     * Return timezone value based on given city name.
     *
     * @param  string  $city
     * @param  string|null  $default
     * @return string|null
     */
    public static function getTimezone(string $city, string $default = null): ?string
    {
        $timezone = static::collection()->first(function (array $timezone) use ($city) {
            return Str::contains($timezone['city'], Str::lower($city));
        }, []);

        return $timezone['timezone'] ?? $default;
    }
}
