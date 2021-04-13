<?php

namespace Ianrizky\MoslemPray\Drivers;

use Ianrizky\MoslemPray\Contracts\Driverable;
use Ianrizky\MoslemPray\Support\Curl\Request;
use Ianrizky\MoslemPray\Support\Curl\Response;
use InvalidArgumentException;
use O2System\Kernel\Http\Message\Uri;

abstract class AbstractDriver implements Driverable
{
    /**
     * List of configuration value.
     *
     * @var array
     */
    protected $config = [];

    /**
     * List of basic configuration value.
     *
     * @var array
     */
    protected $basicConfig = [
        'timeout' => 2000, // in milliseconds
    ];

    /**
     * O2System\Curl\Request instance.
     *
     * @var \Ianrizky\MoslemPray\Support\Curl\Request
     */
    protected $http;

    /**
     * O2System\Kernel\Http\Message\Uri instance.
     *
     * @var \O2System\Kernel\Http\Message\Uri
     */
    protected $uri;

    /**
     * Create a new instance class.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->mergeConfig($config);
        $this->checkConfig('uri', 'timeout');

        $this->createHttpInstance();
        $this->createUriInstance();
    }

    /**
     * Merge given configuration value with existing default configuration.
     *
     * @param  array  $config
     * @return void
     */
    protected function mergeConfig(array $config = [])
    {
        $this->config = array_merge($this->basicConfig, $this->config, $config);
    }

    /**
     * Create O2System\Curl\Request instance.
     *
     * @return void
     */
    protected function createHttpInstance()
    {
        $this->http = Request::make();

        if ($config = $this->config['timeout']) {
            $this->http->setTimeout($config, true);
        }
    }

    /**
     * Create O2System\Kernel\Http\Message\Uri instance.
     *
     * @return void
     */
    protected function createUriInstance()
    {
        $this->uri = new Uri($this->config['uri']);
    }

    /**
     * Run checking for specified configuration key.
     *
     * @param  string|array  $key
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    protected function checkConfig($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->config)) {
                throw new InvalidArgumentException($key . ' is not available.');
            }
        }
    }

    /**
     * Throw a Exception exception if the given json status is error.
     *
     * @param  \Ianrizky\MoslemPray\Support\Curl\Response  $response
     * @return \Ianrizky\MoslemPray\Support\Curl\Response
     *
     * @throws \Exception
     */
    abstract protected function throwJsonError(Response $response);
}
