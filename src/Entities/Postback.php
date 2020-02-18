<?php

namespace Eduzz\ContactCenter\Entities;

class Postback
{
    private $method;
    private $protocol;
    private $url;
    private $headers;

    public function __construct(string $method, string $url, string $protocol = 'http', array $headers)
    {
        $this->method = $method;
        $this->url  = $url;
        $this->protocol  = $protocol;
        $this->headers  = $headers;
    }

    public function toArray()
    {
        $data['method'] = $this->method;
        $data['url'] = $this->url;
        $data['protocol'] = $this->protocol;
        if ($this->headers) {
            $data['headers'] = $this->headers;
        }
        return $data;
    }
}
