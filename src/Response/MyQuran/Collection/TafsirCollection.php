<?php

namespace Ianrizky\MoslemPray\Response\MyQuran\Collection;

use Ianrizky\MoslemPray\Contracts\Response\Responsable;
use Ianrizky\MoslemPray\Response\MyQuran\Tafsir;
use Illuminate\Http\Client\Response;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * @method \Ianrizky\MoslemPray\Response\MyQuran\Tafsir current()
 */
class TafsirCollection extends DataTransferObjectCollection implements Responsable
{
    /**
     * {@inheritDoc}
     */
    public static function fromResponse(Response $response)
    {
        return new static(array_map(function ($entity) {
            return new Tafsir([
                'id' => $entity['tafsir_id'],
                'name' => $entity['aya_name'],
                'surat_number' => $entity['sura_id'],
                'ayat_number' => $entity['aya_number'],
                'mufasir' => $entity['mufasir'],
                'text' => $entity['text'],
                'html' => $entity['html'] ?? null,
            ]);
        }, $response->json('data')));
    }
}
