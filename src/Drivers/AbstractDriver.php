<?php

namespace Ianrizky\MoslemPray\Drivers;

use Ianrizky\MoslemPray\Contracts\Driverable;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use InvalidArgumentException;

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
     * Illuminate\Http\Client\PendingRequest instance.
     *
     * @var \Illuminate\Http\Client\PendingRequest
     */
    protected $request;

    /**
     * Create a new instance class.
     *
     * @param  array  $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->mergeConfig($config);
        $this->checkConfig('url', 'timeout');

        $this->createHttpInstance();
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
     * Create Illuminate\Http\Client\PendingRequest instance.
     *
     * @return void
     */
    protected function createHttpInstance()
    {
        $this->request = tap(new PendingRequest(new Factory), function (PendingRequest $request) {
            $request->baseUrl($this->config['url']);

            transform($this->config['timeout'], function ($timeout) use ($request) {
                $request->timeout($timeout, true);
            });
        });
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
     * @param  \Illuminate\Http\Client\Response  $response
     * @return \Illuminate\Http\Client\Response
     *
     * @throws \Exception
     */
    abstract protected function throwJsonError(Response $response): Response;
}
