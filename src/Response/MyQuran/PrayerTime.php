<?php

namespace Ianrizky\MoslemPray\Response\MyQuran;

use Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime;
use Ianrizky\MoslemPray\Support\Timezone;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class PrayerTime extends DataTransferObject implements HasPrayerTime
{
    /** @var \Ianrizky\MoslemPray\Response\MyQuran\City */
    public $city;

    /** @var \Illuminate\Support\Carbon */
    public $date;

    /** @var \Illuminate\Support\Carbon */
    public $imsak;

    /** @var \Illuminate\Support\Carbon */
    public $subuh;

    /** @var \Illuminate\Support\Carbon */
    public $terbit;

    /** @var \Illuminate\Support\Carbon */
    public $dhuha;

    /** @var \Illuminate\Support\Carbon */
    public $dzuhur;

    /** @var \Illuminate\Support\Carbon */
    public $ashar;

    /** @var \Illuminate\Support\Carbon */
    public $maghrib;

    /** @var \Illuminate\Support\Carbon */
    public $isya;

    /**
     * {@inheritDoc}
     */
    public static function fromResponse(Response $response)
    {
        $city = data_get($response->json(), 'data.lokasi');
        $timezone = Timezone::getTimezone($city, 'Asia/Jakarta');
        $date = Carbon::parse(data_get($response->json(), 'data.jadwal.date'), $timezone);

        return new static([
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
            'imsak' => $date->copy()->setTimeFromTimeString(data_get($response->json(), 'data.jadwal.imsak')),
            'subuh' => $date->copy()->setTimeFromTimeString(data_get($response->json(), 'data.jadwal.subuh')),
            'terbit' => $date->copy()->setTimeFromTimeString(data_get($response->json(), 'data.jadwal.terbit')),
            'dhuha' => $date->copy()->setTimeFromTimeString(data_get($response->json(), 'data.jadwal.dhuha')),
            'dzuhur' => $date->copy()->setTimeFromTimeString(data_get($response->json(), 'data.jadwal.dzuhur')),
            'ashar' => $date->copy()->setTimeFromTimeString(data_get($response->json(), 'data.jadwal.ashar')),
            'maghrib' => $date->copy()->setTimeFromTimeString(data_get($response->json(), 'data.jadwal.maghrib')),
            'isya' => $date->copy()->setTimeFromTimeString(data_get($response->json(), 'data.jadwal.isya')),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getImsak(): Carbon
    {
        return $this->imsak;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubuh(): Carbon
    {
        return $this->subuh;
    }

    /**
     * {@inheritDoc}
     */
    public function getSunrise(): Carbon
    {
        return $this->terbit;
    }

    /**
     * {@inheritDoc}
     */
    public function getDhuha(): Carbon
    {
        return $this->dhuha;
    }

    /**
     * {@inheritDoc}
     */
    public function getDzuhur(): Carbon
    {
        return $this->dzuhur;
    }

    /**
     * {@inheritDoc}
     */
    public function getAshar(): Carbon
    {
        return $this->ashar;
    }

    /**
     * {@inheritDoc}
     */
    public function getMaghrib(): Carbon
    {
        return $this->maghrib;
    }

    /**
     * {@inheritDoc}
     */
    public function getIsya(): Carbon
    {
        return $this->isya;
    }
}
