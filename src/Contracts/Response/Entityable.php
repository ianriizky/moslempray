<?php

namespace Ianrizky\MoslemPray\Contracts\Response;

interface Entityable
{
    /**
     * Create a new instance class from the given entity.
     *
     * @param  array  $entity
     * @return static
     */
    public static function fromEntity(array $entity);
}
