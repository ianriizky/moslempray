<?php

namespace Ianrizky\MoslemPray\Drivers;

use Exception;
use Ianrizky\MoslemPray\Contracts\Response\HasPrayerTime;
use Ianrizky\MoslemPray\Contracts\Response\HasPrayerTimeCollection;
use Ianrizky\MoslemPray\Response\MyQuran\City;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\CityCollection;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\PrayerTimeCollection;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\TafsirCollection;
use Ianrizky\MoslemPray\Response\MyQuran\PrayerTime;
use Ianrizky\MoslemPray\Support\ParseDate;
use Illuminate\Http\Client\Response;

/**
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
     * Return city information based on the given id.
     *
     * @param  mixed  $id
     * @return \Ianrizky\MoslemPray\Response\MyQuran\City
     *
     * @see https://api.myquran.com/v1/sholat/kota/id/{id}
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#88549bc5-cd70-4ba1-b565-f3eef882e060 (Sholat/Lokasi/ID Kota)
     */
    public function getCityFromId($id): City
    {
        $response = $this->throwJsonError(
            $this->request->get('/sholat/kota/id/' . $id)
        );

        return new City([
            'id' => $response->json('data.id'),
            'name' => $response->json('data.lokasi'),
        ]);
    }

    /**
     * Return city information based on the given name.
     *
     * @param  string  $name
     * @return \Ianrizky\MoslemPray\Response\MyQuran\City
     *
     * @see https://api.myquran.com/v1/sholat/kota/cari/{name}
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#ae4b237c-e97c-4353-9e94-67d155af06f8 (Sholat/Lokasi/Pencarian)
     */
    public function getCityFromName(string $name): City
    {
        $response = $this->throwJsonError(
            $this->request->get('/sholat/kota/cari/' . $name)
        );

        return new City([
            'id' => $response->json('data.0.id'),
            'name' => $response->json('data.0.lokasi'),
        ]);
    }

    /**
     * Return list of all city.
     *
     * @return \Ianrizky\MoslemPray\Response\MyQuran\Collection\CityCollection
     *
     * @see https://api.myquran.com/v1/sholat/kota/semua
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#145bcb30-dba6-4d24-9799-03ba878b5476 (Sholat/Lokasi/Semua Kota)
     */
    public function getCities(): CityCollection
    {
        $response = $this->throwJsonError(
            $this->request->get('/sholat/kota/semua')
        );

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
     * @see https://api.myquran.com/v1/sholat/jadwal/{city_id}/{year}/{month}/{date}
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#534da562-3335-4a1f-bca2-d7ee2266f457 (Sholat/Jadwal/Per Hari)
     */
    public function getPrayerTime($city, $date = null): HasPrayerTime
    {
        $city = $this->getCity($city);
        $date = $this->parseDate($date);

        $response = $this->throwJsonError(
            $this->request->get(sprintf('/sholat/jadwal/%s/%s', $city->id, $date->format('Y/m/d')))
        );

        return PrayerTime::fromResponse($response);
    }

    /**
     * {@inheritDoc}
     *
     * @see https://api.myquran.com/v1/sholat/jadwal/{city_id}/{year}/{month}
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#b0b39104-8216-49fc-9d3b-ea53e5832e16 (Sholat/Jadwal/Per Bulan)
     */
    public function getPrayerTimePerMonth($city, $year = null, int $month = null): HasPrayerTimeCollection
    {
        $city = $this->getCity($city);

        if ($year && $month) {
            $date = $this->parseDate($year . '-' . $month . '-1');
        } else {
            $date = $this->parseDate($year);
        }

        $response = $this->throwJsonError(
            $this->request->get(sprintf('/sholat/jadwal/%s/%s', $city->id, $date->format('Y/m')))
        );

        return PrayerTimeCollection::fromResponse($response);
    }

    /**
     * Return list of tafsir based on the given ayat number.
     *
     * @param  int  $ayat
     * @return mixed
     *
     * @see https://api.myquran.com/v1/tafsir/quran/kemenag/id/{id}
     * @see https://documenter.getpostman.com/view/841292/Tz5p7yHS#9065c3f0-23b7-48b6-884a-a28da0826e03 (Tafsir/alQuran/Kemenag/id)
     */
    public function getTafsir(int $ayat)
    {
        $response = $this->throwJsonError(
            $this->request->get('/tafsir/quran/kemenag/id/' . $ayat)
        );

        return TafsirCollection::fromResponse($response);
    }

    /**
     * {@inheritDoc}
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
