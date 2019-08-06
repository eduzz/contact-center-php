<?php

namespace Eduzz\ContactCenter\Entities;

class Person
{
    private $name;
    private $email;

    public function __construct(string $email, string $name = null)
    {
        $this->email = $email;
        $this->name  = $name;
    }

    public function toArray()
    {
        $data['email'] = $this->email;
        if ($this->name) {
            $data['name'] = $this->name;
        }

        return $data;
    }
}
