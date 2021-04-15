<?php

namespace Ianrizky\MoslemPray\Response\MyQuran\Collection;

use Ianrizky\MoslemPray\Response\MyQuran\City;
use Spatie\DataTransferObject\DataTransferObjectCollection;

/**
 * @method \Ianrizky\MoslemPray\Response\MyQuran\City current()
 */
class CityCollection extends DataTransferObjectCollection
{
    /**
     * Create a new instance class.
     *
     * @param  array  $collection
     * @return void
     */
    public function __construct(array $collection = [])
    {
        $this->collection = array_map(function ($entity) {
            return new City($entity);
        }, $collection);
    }
}
