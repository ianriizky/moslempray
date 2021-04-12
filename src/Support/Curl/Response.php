<?php

namespace Ianrizky\MoslemPray\Support\Curl;

use O2System\Curl\Response as BaseResponse;
use O2System\Curl\Response\SimpleJSONElement;

class Response extends BaseResponse
{
    /**
     * Get the JSON decoded body of the response as an array or scalar value.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function json($key = null, $default = null)
    {
        if ($this->getBody() instanceof SimpleJSONElement) {
            if (is_null($key)) {
                return $this->getBody()->getArrayCopy();
            }

            return data_get($this->getBody()->getArrayCopy(), $key, $default);
        }

        return $default;
    }
}
