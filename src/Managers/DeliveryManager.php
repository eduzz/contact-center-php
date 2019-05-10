<?php

namespace Eduzz\ContactCenter\Managers;

use Eduzz\ContactCenter\Messages\Message;
use Eduzz\ContactCenter\Traits\Configuration;


class DeliveryManager extends Manager
{
  
  use Configuration;

  private $messages;

  public function __construct() {
    
  }

  public function send(Message $message = null) 
  {
    if ($message){
      $message->send();
      return;
    }

    foreach($this->messages as $message) {
      $message->send();
    }
  }

  public function addMessage(Message $message) 
  {
    $this->messages[] = $message;
  }

  public function clear() 
  {
    $this->messages = [];
  }

}