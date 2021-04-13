<?php

namespace Ianrizky\MoslemPray\Response\MyQuran;

use Spatie\DataTransferObject\DataTransferObject;

class City extends DataTransferObject
{
    public $id;

    /**
     * Alias: koordinat.
     *
     * @var \Ianrizky\MoslemPray\Response\MyQuran\Coordinate|null
     */
    public $coordinate;

    /**
     * Alias: lokasi.
     *
     * @var string
     */
    public $name;

    /**
     * Alias: daerah.
     *
     * @var string|null
     */
    public $region;
}
