<?php

namespace Ianrizky\MoslemPray\Response\MyQuran;

use Spatie\DataTransferObject\DataTransferObject;

class Coordinate extends DataTransferObject
{
    /**
     * Alias: lat.
     *
     * @var float
     */
    public $latitude;

    /**
     * Alias: lon.
     *
     * @var float
     */
    public $longitude;

    /**
     * Alias: lintang.
     *
     * @var string
     */
    public $latitude_degree;

    /**
     * Alias: bujur.
     *
     * @var string
     */
    public $longitude_degree;
}
