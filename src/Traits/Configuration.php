<?php

namespace Eduzz\ContactCenter\Traits;

trait Configuration
{
    private $config;

    public function setConfig($config)
    {
        $this->config = $config;
    }
}
