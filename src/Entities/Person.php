<?php

namespace Eduzz\ContactCenter\Entities;

class Person
{
    private $name;
    private $email;
    private $params;

    public function __construct(string $email, string $name = null, array $params = null)
    {
        $this->email = $email;
        $this->name  = $name;
        $this->params = $params;
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

        return $data;
    }
}
