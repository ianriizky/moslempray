# ianriizky-moslempray

[![Build Status](https://travis-ci.com/ianriizky/moslempray.svg)](https://travis-ci.org/ianriizky/moslempray)
[![Quality Score](https://img.shields.io/scrutinizer/g/ianriizky/moslempray.svg?style=flat)](https://scrutinizer-ci.com/g/ianriizky/moslempray)
[![Code Coverage](https://scrutinizer-ci.com/g/ianriizky/moslempray/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ianriizky/moslempray)
[![Latest Stable Version](https://poser.pugx.org/ianriizky/moslempray/v/stable.svg)](https://packagist.org/packages/ianriizky/moslempray)
[![Total Downloads](https://poser.pugx.org/ianriizky/moslempray/d/total.svg)](https://packagist.org/packages/ianriizky/moslempray)
[![Software License](https://poser.pugx.org/ianriizky/moslempray/license.svg)](https://packagist.org/packages/ianriizky/moslempray)

ianriizky-moslempray is a API Manager to find pray time for Moslem developed for PHP and Laravel Framework.

There are 3 driver that available to use so far:
- aladhan [(documentation)](https://aladhan.com/prayer-times-api) ***still WIP***
- myquran [(documentation)](https://documenter.getpostman.com/view/841292/Tz5p7yHS)
- prayertimes [(documentation 1)](https://prayertimes.date/api) [(doucumentation 2)](https://waktusholat.org/api/docs/today) ***still WIP***

## Software requirements
- PHP version ^7.3

## Instalation
You can install the package via composer:

```bash
composer require ianriizky/moslempray
```
> Packagist: [https://packagist.org/packages/ianriizky/moslempray](https://packagist.org/packages/ianriizky/moslempray)

## Usage
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ianrizky\MoslemPray\MoslemPray;
use Illuminate\Support\Carbon;

// Common request
$moslemPray = MoslemPray::getPrayerTime('denpasar');

// Common request with specified date (use Carbon power)
// @see https://carbon.nesbot.com/docs/
$moslemPray = MoslemPray::getPrayerTime('denpasar', '2021-04-12');
$moslemPray = MoslemPray::getPrayerTime('denpasar', Carbon::today());

// Request using "myquran" driver
$moslemPray = MoslemPray::myquran()->getPrayerTimePerMonth('denpasar');
$moslemPray = MoslemPray::myquran()->getPrayerTimePerMonth('denpasar', 2021, 4);

```

## Testing
```bash
phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits
| Role | Name |
| ---- | ---- |
| Owner | [Septianata Rizky Pratama](https://github.com/ianriizky) |
