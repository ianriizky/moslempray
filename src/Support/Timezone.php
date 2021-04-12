<?php

namespace Ianrizky\MoslemPray\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Timezone
{
    /**
     * Return collection of city with its timezone value.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function collection(): Collection
    {
        $collection = [];

        $handle = fopen('storage/timezone.ndjson', 'r');

        while (($line = fgets($handle)) !== false) {
            $collection[] = json_decode($line, true);
        }

        return Collection::make($collection);
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
