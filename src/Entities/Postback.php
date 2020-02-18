<?php

namespace Eduzz\ContactCenter\Entities;

class Postback
{
    private $method;
    private $url;
    private $headers;

    public function __construct(string $method, string $url, array $headers)
    {
        $this->method = $method;
        $this->url  = $url;
        $this->headers  = $headers;
    }

    public function toArray()
    {
        $data['method'] = $this->method;
        $data['url'] = $this->url;
        if ($this->headers) {
            $data['headers'] = $this->headers;
        }
        return $data;
    }
}
