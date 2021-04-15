<?php

namespace Ianrizky\MoslemPray;

use Illuminate\Support\Manager as BaseManager;

class Manager extends BaseManager
{
    /**
     * {@inheritDoc}
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('moslempray.driver', MoslemPray::$defaultDriverName);
    }

    /**
     * {@inheritDoc}
     */
    protected function createDriver($driver)
    {
        return MoslemPray::createDriverInstance($driver, array_merge([
            'timeout' => $this->config->get('timeout'),
        ], $this->config->get('moslempray.' . $driver, [])));
    }
}
