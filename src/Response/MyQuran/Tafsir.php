<?php

namespace Ianrizky\MoslemPray\Response\MyQuran;

use Spatie\DataTransferObject\DataTransferObject;

class Tafsir extends DataTransferObject
{
    /** Alias: tafsir_id. */
    public $id;

    /**
     * Alias: aya_name.
     *
     * @var string
     */
    public $name;

    /**
     * Alias: sura_id.
     *
     * @var int
     */
    public $surat_number;

    /**
     * Alias: aya_number.
     *
     * @var int
     */
    public $ayat_number;

    /** @var string */
    public $mufasir;

    /** @var string */
    public $text;

    /** @var string|null */
    public $html;
}
