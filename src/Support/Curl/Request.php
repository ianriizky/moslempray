<?php

namespace Ianrizky\MoslemPray\Support\Curl;

use Exception;
use Illuminate\Support\Traits\Tappable;
use O2System\Curl\Request as BaseRequest;

/**
 * @method \Ianrizky\MoslemPray\Support\Curl\Response get(array $query = []) Get response use HTTP GET request method.
 * @method \Ianrizky\MoslemPray\Support\Curl\Response post(array $fields = []) Get response use HTTP POST request method.
 * @method \Ianrizky\MoslemPray\Support\Curl\Response delete(array $fields = []) Get response use custom HTTP DELETE request method.
 * @method \Ianrizky\MoslemPray\Support\Curl\Response head() Get response use custom HTTP HEAD request method.
 * @method \Ianrizky\MoslemPray\Support\Curl\Response trace() Get response use custom HTTP TRACE request method.
 * @method \Ianrizky\MoslemPray\Support\Curl\Response patch() Get response use custom HTTP PATCH request method.
 * @method \Ianrizky\MoslemPray\Support\Curl\Response connect() Get response use custom HTTP CONNECT request method.
 * @method \Ianrizky\MoslemPray\Support\Curl\Response download() Get response use custom HTTP DOWNLOAD request method.
 */
class Request extends BaseRequest
{
    use Tappable;

    /**
     * Create a new instance class in static way.
     *
     * @return static
     */
    public static function make()
    {
        return new static;
    }

    /**
     * {@inheritDoc}
     *
     * @return \Ianrizky\MoslemPray\Support\Curl\Response
     *
     * @throws \Exception
     */
    public function getResponse()
    {
        if(array_key_exists(CURLOPT_URL, $this->curlOptions)) {
            $handle = curl_init();
        } else {
            $handle = curl_init($this->uri->__toString());
        }

        $headers = [];
        if (count($this->curlHeaders)) {
            foreach ($this->curlHeaders as $key => $value) {
                $headers[] = trim($key) . ': ' . trim($value);
            }

            $this->curlOptions[ CURLOPT_HTTPHEADER ] = $headers;
        }

        if (curl_setopt_array($handle, $this->curlOptions)) {
            $response = (new Response($handle))
                ->setInfo(curl_getinfo($handle))
                ->setContent(curl_exec($handle));

            if ($this->curlAutoClose) {
                curl_close($handle);
            }

            return $response;
        }

        throw new Exception(sprintf('HTTP error %s: %s', curl_errno($handle), curl_error($handle)));
    }
}
