<?php

namespace Ianrizky\MoslemPray\Contracts\Response;

use Illuminate\Http\Client\Response;

interface Responsable
{
    /**
     * Create a new instance class from the given response.
     *
     * @param  \Illuminate\Http\Client\Response  $response
     * @return static
     */
    public static function fromResponse(Response $response);
}
