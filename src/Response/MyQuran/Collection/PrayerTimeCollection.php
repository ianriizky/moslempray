<?php

namespace Ianrizky\MoslemPray\Response\MyQuran\Collection;

use Ianrizky\MoslemPray\Contracts\Response\HasPrayerTimeCollection;
use Ianrizky\MoslemPray\Response\MyQuran\PrayerTime;
use Ianrizky\MoslemPray\Support\Timezone;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * @method \Ianrizky\MoslemPray\Response\MyQuran\PrayerTime current()
 */
class PrayerTimeCollection extends DataTransferObjectCollection implements HasPrayerTimeCollection
{
    /**
     * Create a new instance class.
     *
     * @param  array  $collection
     * @return void
     */
    public function __construct(array $collection = [])
    {
        $this->collection = array_map(function ($entity) {
            return new PrayerTime($entity);
        }, $collection);
    }

    /**
     * {@inheritDoc}
     */
    public static function fromResponse(Response $response)
    {
        $city = data_get($response->json(), 'data.lokasi');
        $timezone = Timezone::getTimezone($city, 'Asia/Jakarta');

        return new static(array_map(function ($entity) use ($response, $city, $timezone) {
            $date = Carbon::parse($entity['date'], $timezone);

            return [
                'city' => [
                    'id' => data_get($response->json(), 'data.id'),
                    'coordinate' => [
                        'latitude' => data_get($response->json(), 'data.koordinat.lat'),
                        'longitude' => data_get($response->json(), 'data.koordinat.lon'),
                        'latitude_degree' => data_get($response->json(), 'data.koordinat.lintang'),
                        'longitude_degree' => data_get($response->json(), 'data.koordinat.bujur'),
                    ],
                    'name' => $city,
                    'region' => data_get($response->json(), 'data.daerah'),
                ],
                'date' => $date,
                'imsak' => $date->copy()->setTimeFromTimeString($entity['imsak']),
                'subuh' => $date->copy()->setTimeFromTimeString($entity['subuh']),
                'terbit' => $date->copy()->setTimeFromTimeString($entity['terbit']),
                'dhuha' => $date->copy()->setTimeFromTimeString($entity['dhuha']),
                'dzuhur' => $date->copy()->setTimeFromTimeString($entity['dzuhur']),
                'ashar' => $date->copy()->setTimeFromTimeString($entity['ashar']),
                'maghrib' => $date->copy()->setTimeFromTimeString($entity['maghrib']),
                'isya' => $date->copy()->setTimeFromTimeString($entity['isya']),
            ];
        }, data_get($response->json(), 'data.jadwal')));
    }
}

