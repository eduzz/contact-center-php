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

    /**
     * Apply the callback's if the given "value" is true.
     *
     * @param  mixed  $value
     * @param  callable  $callback
     * @param  callable|null  $default
     * @return mixed|$this
     */
    public function when($value, $callback, $default = null)
    {
        if ($value) {
            return $callback($this, $value) ?: $this;
        } elseif ($default) {
            return $default($this, $value) ?: $this;
        }

        return $this;
    }

    abstract public function send();
}
