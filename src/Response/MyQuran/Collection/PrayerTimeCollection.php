<?php

namespace Ianrizky\MoslemPray\Response\MyQuran\Collection;

use Ianrizky\MoslemPray\Contracts\Responsable;
use Ianrizky\MoslemPray\Response\MyQuran\PrayerTime;
use Ianrizky\MoslemPray\Support\Curl\Response;
use Ianrizky\MoslemPray\Support\Timezone;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * @method \Ianrizky\MoslemPray\Response\MyQuran\PrayerTime current()
 */
class PrayerTimeCollection extends DataTransferObjectCollection implements Responsable
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
        $city = $response->json('data.lokasi');
        $timezone = Timezone::getTimezone($city, 'Asia/Jakarta');

        return new static(array_map(function ($entity) use ($response, $city, $timezone) {
            $date = Carbon::parse($entity['date'], $timezone);

            return [
                'city' => [
                    'id' => $response->json('data.id'),
                    'coordinate' => [
                        'latitude' => $response->json('data.koordinat.lat'),
                        'longitude' => $response->json('data.koordinat.lon'),
                        'latitude_degree' => $response->json('data.koordinat.lintang'),
                        'longitude_degree' => $response->json('data.koordinat.bujur'),
                    ],
                    'name' => $city,
                    'region' => $response->json('data.daerah'),
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
        }, $response->json('data.jadwal')));
    }
}
