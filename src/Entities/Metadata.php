<?php

namespace Eduzz\ContactCenter\Entities;

use JsonSerializable;

class Metadata implements JsonSerializable
{

    public function __construct()
    {

    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return true;
    }

}
