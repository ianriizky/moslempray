<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default MoslemPray API Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default moslem pray API driver that will be used
    | to get the pray data.
    |
    | Supported:
    |       "aladhan" => , "https://aladhan.com/prayer-times-api",
    |       "myquran" => "https://documenter.getpostman.com/view/841292/Tz5p7yHS",
    |       "prayertimes" => [https://prayertimes.date/api, https://waktusholat.org/api/docs/today],
    |
    */

    'driver' => 'myquran',

    /*
    |--------------------------------------------------------------------------
    | Timeout Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls the maximum number of milliseconds to allow cURL functions to execute.
    | Note: Set to "null" to disable this configuration.
    |
    */
    'timeout' => 2000,

    /*
    |--------------------------------------------------------------------------
    | MyQuran Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls the configuration on "myquran" driver.
    |
    */
    'myquran' => [
        'url' => 'https://api.myquran.com/v1/',
    ],

];
