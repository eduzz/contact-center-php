<?php

namespace Eduzz\ContactCenter\Messages;

use Eduzz\ContactCenter\Traits\ExceptionFormatter;

abstract class Message
{
    use ExceptionFormatter;

    protected $schedule;
    protected $template;
    protected $callbackError;

    public function template(string $templateId)
    {
        $this->template = $templateId;
        return $this;
    }

    public function schedule(float $timestamp)
    {
        $this->schedule = $timestamp;
        return $this;
    }

    public function metadata(array $metadata)
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function onError(callable $callback)
    {
        $this->callbackError = $callback;
        return $this;
    }

    abstract public function send();
}
