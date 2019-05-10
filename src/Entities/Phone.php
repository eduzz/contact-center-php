<?php

namespace Eduzz\ContactCenter\Entities;

class Phone
{
  private $countryCode;
  private $areaCode;
  private $phoneNumber;

  public function __construct(string $countryCode, 
                              string $areaCode, 
                              string $phoneNumber)
  {
    $this->countryCode = $countryCode;
    $this->areaCode = $areaCode;
    $this->phoneNumber = $phoneNumber;
  }

  public function toArray()
  {
    return [
      'countryCode' => $this->countryCode,
      'areaCode' => $this->areaCode,
      'phoneNumber' => $this->phoneNumber,
    ];
  }
}