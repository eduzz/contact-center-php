<?php

namespace Eduzz\ContactCenter\Entities;

use JsonSerializable;

class Person implements JsonSerializable
{
    private $name;
    private $email;
    private $params;
    private $postback;

    public function __construct(string $email, string $name = null, array $params = null, Postback $postback = null)
    {
        $this->email = $email;
        $this->name  = $name;
        $this->params = $params;
        $this->postback = $postback;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $data['email'] = $this->email;
        if ($this->name) {
            $data['name'] = $this->name;
        }
        if ($this->params) {
            $data['params'] = $this->params;
        }
        if ($this->postback) {
            $data['postback'] = $this->postback;
        }

        return $data;
    }
}
