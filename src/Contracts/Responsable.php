<?php

namespace Ianrizky\MoslemPray\Contracts;

use Ianrizky\MoslemPray\Support\Curl\Response;

interface Responsable
{
    /**
     * Create a new instance class from the given response.
     *
     * @param  \Ianrizky\MoslemPray\Support\Curl\Response  $response
     * @return static
     */
    public static function fromResponse(Response $response);
}
