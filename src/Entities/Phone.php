<?php

namespace Eduzz\ContactCenter\Entities;

use JsonSerializable;

class Phone implements JsonSerializable
{
    private $countryCode;
    private $areaCode;
    private $phoneNumber;

    public function __construct(string $countryCode,
        string $areaCode,
        string $phoneNumber) {
        $this->countryCode = $countryCode;
        $this->areaCode    = $areaCode;
        $this->phoneNumber = $phoneNumber;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return [
            'countryCode' => $this->countryCode,
            'areaCode'    => $this->areaCode,
            'phoneNumber' => $this->phoneNumber,
        ];
    }
}
