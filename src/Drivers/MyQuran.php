<?php

namespace Ianrizky\MoslemPray\Drivers;

use Exception;
use Ianrizky\MoslemPray\Response\MyQuran\City;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\CityCollection;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\PrayerTimeCollection;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\TafsirCollection;
use Ianrizky\MoslemPray\Response\MyQuran\PrayerTime;
use Ianrizky\MoslemPray\Support\Curl\Response;
use Ianrizky\MoslemPray\Support\ParseDate;

/**
 * @see https://api.myquran.com
 * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS
 */
class MyQuran extends AbstractDriver
{
    use ParseDate;

    /**
     * List of configuration value.
     *
     * @var array
     */
    protected $config = [
        'uri' => 'https://api.myquran.com/v1/',
    ];

    /**
     * Return city information based on the given identifier.
     *
     * @param  mixed  $identifier
     * @return \Ianrizky\MoslemPray\Response\MyQuran\City
     */
    public function getCity($identifier): City
    {
        if (is_numeric($identifier)) {
            return $this->getCityFromId($identifier);
        }

        return $this->getCityFromName($identifier);
    }

    /**
     * Return city information based on the given name.
     *
     * @param  string  $name
     * @return \Ianrizky\MoslemPray\Response\MyQuran\City
     *
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#ae4b237c-e97c-4353-9e94-67d155af06f8 (Sholat/Lokasi/Pencarian)
     */
    public function getCityFromName(string $name): City
    {
        $uri = $this->uri->addPath('/sholat/kota/cari/' . $name);
        $response = $this->throwJsonError($this->http->setUri($uri)->get());

        return new City([
            'id' => $response->json('data.0.id'),
            'name' => $response->json('data.0.lokasi'),
        ]);
    }

    /**
     * Return city information based on the given id.
     *
     * @param  mixed  $id
     * @return \Ianrizky\MoslemPray\Response\MyQuran\City
     *
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#88549bc5-cd70-4ba1-b565-f3eef882e060 (Sholat/Lokasi/ID Kota)
     */
    public function getCityFromId($id): City
    {
        $uri = $this->uri->addPath('/sholat/kota/id/' . $id);
        $response = $this->throwJsonError($this->http->setUri($uri)->get());

        return new City([
            'id' => $response->json('data.id'),
            'name' => $response->json('data.lokasi'),
        ]);
    }

    /**
     * Return list of all city.
     *
     * @return \Ianrizky\MoslemPray\Response\MyQuran\Collection\CityCollection
     *
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#145bcb30-dba6-4d24-9799-03ba878b5476 (Sholat/Lokasi/Semua Kota)
     */
    public function getCities(): CityCollection
    {
        $uri = $this->uri->addPath('/sholat/kota/semua');
        $response = $this->throwJsonError($this->http->setUri($uri)->get());

        return new CityCollection(array_map(function ($data) {
            return [
                'id' => $data['id'],
                'name' => $data['lokasi'],
            ];
        }, $response->json()));
    }

    /**
     * {@inheritDoc}
     *
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#534da562-3335-4a1f-bca2-d7ee2266f457 (Sholat/Jadwal/Per Hari)
     */
    public function getPrayerTime($city, $date = null)
    {
        $city = $this->getCity($city);
        $date = $this->parseDate($date);

        $uri = $this->uri->addPath(sprintf('/sholat/jadwal/%s/%s',
            $city->id, $date->format('Y/m/d')
        ));

        return PrayerTime::fromResponse(
            $this->throwJsonError($this->http->setUri($uri)->get())
        );
    }

    /**
     * Return list of prayer time based on the given city and month.
     *
     * @param  mixed  $city
     * @param  \Illuminate\Support\Carbon|int|null  $year
     * @param  int|null  $month
     * @return \Ianrizky\MoslemPray\Response\MyQuran\Collection\PrayerTimeCollection
     *
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#b0b39104-8216-49fc-9d3b-ea53e5832e16 (Sholat/Jadwal/Per Bulan)
     */
    public function getPrayerTimePerMonth($city, $year = null, int $month = null): PrayerTimeCollection
    {
        $city = $this->getCity($city);

        if ($year && $month) {
            $date = $this->parseDate($year . '-' . $month . '-1');
        } else {
            $date = $this->parseDate($year);
        }

        $uri = $this->uri->addPath(sprintf('/sholat/jadwal/%s/%s',
            $city->id, $date->format('Y/m')
        ));

        return PrayerTimeCollection::fromResponse(
            $this->throwJsonError($this->http->setUri($uri)->get())
        );
    }

    /**
     * Return list of tafsir based on the given ayat number.
     *
     * @param  int  $ayat
     * @return mixed
     */
    public function getTafsir(int $ayat)
    {
        $uri = $this->uri->addPath('/tafsir/quran/kemenag/id/' . $ayat);
        $response = $this->throwJsonError($this->http->setUri($uri)->get());

        return TafsirCollection::fromResponse($response);
    }

    /**
     * Throw a HttpClientException exception if the given json status is error.
     *
     * @param  \Ianrizky\MoslemPray\Support\Curl\Response  $response
     * @return \Ianrizky\MoslemPray\Support\Curl\Response
     *
     * @throws \Exception
     */
    protected function throwJsonError(Response $response): Response
    {
        $status = $response->json('status', true);
        $message = $response->json('message', 'MyQuran API error');

        if (!$status) {
            throw new Exception($message);
        }

        return $response;
    }
}
