<?php

namespace Tests\Feature;

use Exception;
use Ianrizky\MoslemPray\MoslemPray;
use Ianrizky\MoslemPray\Response\MyQuran\City;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\CityCollection;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\PrayerTimeCollection;
use Ianrizky\MoslemPray\Response\MyQuran\Collection\TafsirCollection;
use Ianrizky\MoslemPray\Response\MyQuran\Coordinate;
use Ianrizky\MoslemPray\Response\MyQuran\PrayerTime;
use Ianrizky\MoslemPray\Response\MyQuran\Tafsir;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MyQuranTest extends TestCase
{
    /**
     * Assert that getCity() method is running properly using id as parameter.
     *
     * @return void
     */
    public function test_asserting_get_city_using_id_success()
    {
        $city = MoslemPray::myquran()->getCity(1709);

        $this->assertCity($city);
    }

    /**
     * Assert that getCity() method is throwing an exception when data not found using id as parameter.
     *
     * @return void
     */
    public function test_asserting_get_city_using_id_failed()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Kota tidak ketemu');

        MoslemPray::myquran()->getCity(1);
    }

    /**
     * Assert that getCity() method is running properly using name as parameter.
     *
     * @return void
     */
    public function test_asserting_get_city_using_name_success()
    {
        $city = MoslemPray::myquran()->getCity('denpasar');

        $this->assertCity($city);
    }

    /**
     * Assert that getCity() method is throwing an exception when data not found using name as parameter.
     *
     * @return void
     */
    public function test_asserting_get_city_using_name_failed()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Kota tidak ketemu');

        MoslemPray::myquran()->getCity('amerika');
    }

    /**
     * Assert that getCityFromId() method is running properly.
     *
     * @return void
     */
    public function test_asserting_get_city_from_id_success()
    {
        $city = MoslemPray::myquran()->getCityFromId(1709);

        $this->assertCity($city);
    }

    /**
     * Assert that getCityFromId() method is throwing an exception when data not found.
     *
     * @return void
     */
    public function test_asserting_get_city_from_id_failed()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Kota tidak ketemu');

        MoslemPray::myquran()->getCityFromId(1);
    }

    /**
     * Assert that getCityFromName() method is running properly.
     *
     * @return void
     */
    public function test_asserting_get_city_from_name_success()
    {
        $city = MoslemPray::myquran()->getCityFromName('denpasar');

        $this->assertCity($city);
    }

    /**
     * Assert that getCityFromName() method is throwing an exception when data not found.
     *
     * @return void
     */
    public function test_asserting_get_city_from_name_failed()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Kota tidak ketemu');

        MoslemPray::myquran()->getCityFromName('amerika');
    }

    /**
     * Assert that getCities() method is running properly.
     *
     * @return void
     */
    public function test_asserting_get_cities()
    {
        $cities = MoslemPray::myquran()->getCities();

        $this->assertInstanceOf(CityCollection::class, $cities);

        foreach ($cities as $city) {
            $this->assertCity($city);
        }
    }

    /**
     * Assert that getPrayerTime() method is running properly.
     *
     * @return void
     */
    public function test_asserting_get_prayer_time()
    {
        $prayerTime = MoslemPray::myquran()->getPrayerTime('denpasar');

        $this->assertPrayerTime($prayerTime);
    }

    /**
     * Assert that getPrayerTimePerMonth() method is running properly.
     *
     * @return void
     */
    public function test_asserting_get_prayer_time_per_month()
    {
        $prayerTimes = MoslemPray::myquran()->getPrayerTimePerMonth('denpasar');

        $this->assertInstanceOf(PrayerTimeCollection::class, $prayerTimes);

        foreach ($prayerTimes as $prayerTime) {
            $this->assertPrayerTime($prayerTime);
        }
    }

    /**
     * Assert that getTafsir() method is running properly.
     *
     * @return void
     */
    public function test_asserting_get_tafsir()
    {
        $tafsirs = MoslemPray::myquran()->getTafsir(rand(1, 6236));

        $this->assertInstanceOf(TafsirCollection::class, $tafsirs);

        foreach ($tafsirs as $tafsir) {
            $this->assertTafsir($tafsir);
        }
    }

    /**
     * Assert the given city object has specified attribute.
     *
     * @param  \Ianrizky\MoslemPray\Response\MyQuran\City  $city
     * @return void
     */
    protected function assertCity($city)
    {
        $this->assertInstanceOf(City::class, $city);

        $this->assertObjectHasAttribute('id', $city);
        $this->assertObjectHasAttribute('coordinate', $city);
        $this->assertObjectHasAttribute('name', $city);
        $this->assertObjectHasAttribute('region', $city);

        $this->assertNotNull($city->id);
        $this->assertIsString($city->name);

        if (!is_null($city->coordinate)) {
            $coordinate = $city->coordinate;

            /** @var \Ianrizky\MoslemPray\Response\MyQuran\Coordinate $coordinate */
            $this->assertInstanceOf(Coordinate::class, $coordinate);

            $this->assertObjectHasAttribute('latitude', $coordinate);
            $this->assertObjectHasAttribute('longitude', $coordinate);
            $this->assertObjectHasAttribute('latitude_degree', $coordinate);
            $this->assertObjectHasAttribute('longitude_degree', $coordinate);

            $this->assertIsFloat($coordinate->latitude);
            $this->assertIsFloat($coordinate->longitude);
            $this->assertIsString($coordinate->latitude_degree);
            $this->assertIsString($coordinate->longitude_degree);
        }

        if (!is_null($city->region)) {
            $this->assertIsString($city->region);
        }
    }

    /**
     * Assert the given prayerTime object has specified attribute.
     *
     * @param  \Ianrizky\MoslemPray\Response\MyQuran\PrayerTime  $prayerTime
     * @return void
     */
    protected function assertPrayerTime($prayerTime)
    {
        $this->assertInstanceOf(PrayerTime::class, $prayerTime);

        $this->assertCity($prayerTime->city);

        $this->assertObjectHasAttribute('date', $prayerTime);
        $this->assertObjectHasAttribute('imsak', $prayerTime);
        $this->assertObjectHasAttribute('subuh', $prayerTime);
        $this->assertObjectHasAttribute('terbit', $prayerTime);
        $this->assertObjectHasAttribute('dhuha', $prayerTime);
        $this->assertObjectHasAttribute('dzuhur', $prayerTime);
        $this->assertObjectHasAttribute('ashar', $prayerTime);
        $this->assertObjectHasAttribute('maghrib', $prayerTime);
        $this->assertObjectHasAttribute('isya', $prayerTime);

        $this->assertInstanceOf(Carbon::class, $prayerTime->date);
        $this->assertInstanceOf(Carbon::class, $prayerTime->imsak);
        $this->assertInstanceOf(Carbon::class, $prayerTime->subuh);
        $this->assertInstanceOf(Carbon::class, $prayerTime->terbit);
        $this->assertInstanceOf(Carbon::class, $prayerTime->dhuha);
        $this->assertInstanceOf(Carbon::class, $prayerTime->dzuhur);
        $this->assertInstanceOf(Carbon::class, $prayerTime->ashar);
        $this->assertInstanceOf(Carbon::class, $prayerTime->maghrib);
        $this->assertInstanceOf(Carbon::class, $prayerTime->isya);
    }

    /**
     * Assert the given tafsir object has specified attribute.
     *
     * @param  \Ianrizky\MoslemPray\Response\MyQuran\Tafsir  $tafsir
     * @return void
     */
    protected function assertTafsir($tafsir)
    {
        $this->assertInstanceOf(Tafsir::class, $tafsir);

        $this->assertObjectHasAttribute('id', $tafsir);
        $this->assertObjectHasAttribute('name', $tafsir);
        $this->assertObjectHasAttribute('surat_number', $tafsir);
        $this->assertObjectHasAttribute('ayat_number', $tafsir);
        $this->assertObjectHasAttribute('mufasir', $tafsir);
        $this->assertObjectHasAttribute('text', $tafsir);
        $this->assertObjectHasAttribute('html', $tafsir);

        $this->assertNotNull($tafsir->id);
        $this->assertIsString($tafsir->name);
        $this->assertIsInt($tafsir->surat_number);
        $this->assertIsInt($tafsir->ayat_number);
        $this->assertIsString($tafsir->mufasir);
        $this->assertIsString($tafsir->text);

        if (!is_null($tafsir->html)) {
            $this->assertIsString($tafsir->html);
        }
    }
}
