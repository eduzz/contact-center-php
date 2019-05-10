<?php

namespace Eduzz\ContactCenter\Exceptions;

class BaseException extends \Exception 
{
  public function getJSON()
  {
    return (object)[
      "error" => true,
      "code" => $this->code,
      "message" => $this->message
    ];
  }
}