<?php

namespace Ianrizky\MoslemPray\Response\MyQuran;

use Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime;
use Ianrizky\MoslemPray\Support\Curl\Response;
use Ianrizky\MoslemPray\Support\Timezone;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class PrayerTime extends DataTransferObject implements HasPrayerTime
{
    /**
     * @var \Ianrizky\MoslemPray\Response\MyQuran\City
     */
    public $city;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $date;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $imsak;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $subuh;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $terbit;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $dhuha;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $dzuhur;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $ashar;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $maghrib;

    /**
     * @var \Illuminate\Support\Carbon
     */
    public $isya;

    /**
     * {@inheritDoc}
     */
    public static function fromResponse(Response $response)
    {
        $city = $response->json('data.lokasi');
        $timezone = Timezone::getTimezone($city, 'Asia/Jakarta');
        $date = Carbon::parse($response->json('data.jadwal.date'), $timezone);

        return new static([
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
            'imsak' => $date->copy()->setTimeFromTimeString($response->json('data.jadwal.imsak')),
            'subuh' => $date->copy()->setTimeFromTimeString($response->json('data.jadwal.subuh')),
            'terbit' => $date->copy()->setTimeFromTimeString($response->json('data.jadwal.terbit')),
            'dhuha' => $date->copy()->setTimeFromTimeString($response->json('data.jadwal.dhuha')),
            'dzuhur' => $date->copy()->setTimeFromTimeString($response->json('data.jadwal.dzuhur')),
            'ashar' => $date->copy()->setTimeFromTimeString($response->json('data.jadwal.ashar')),
            'maghrib' => $date->copy()->setTimeFromTimeString($response->json('data.jadwal.maghrib')),
            'isya' => $date->copy()->setTimeFromTimeString($response->json('data.jadwal.isya')),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getImsak()
    {
        return $this->imsak;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubuh()
    {
        return $this->subuh;
    }

    /**
     * {@inheritDoc}
     */
    public function getSunrise()
    {
        return $this->terbit;
    }

    /**
     * {@inheritDoc}
     */
    public function getDhuha()
    {
        return $this->dhuha;
    }

    /**
     * {@inheritDoc}
     */
    public function getDzuhur()
    {
        return $this->dzuhur;
    }

    /**
     * {@inheritDoc}
     */
    public function getAshar()
    {
        return $this->ashar;
    }

    /**
     * {@inheritDoc}
     */
    public function getMaghrib()
    {
        return $this->maghrib;
    }

    /**
     * {@inheritDoc}
     */
    public function getIsya()
    {
        return $this->isya;
    }
}
