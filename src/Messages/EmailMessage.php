<?php

namespace Eduzz\ContactCenter\Messages;

use Eduzz\ContactCenter\Messages\Message;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Eduzz\ContactCenter\Traits\Configuration;

class EmailMessage extends Message
{

  use Configuration;

  private $to;
  private $cc;
  private $bcc;
  private $replyTo;
  private $from;
  private $params;
  private $subject;
  
  public function __construct(Client $clientHttp) {
    $this->clientHttp = $clientHttp; 
    $this->from = null;
    $this->params = [];
    $this->subject = null;
    $this->to = [];
    $this->cc = [];
    $this->bcc = [];
    $this->replyTo = null;
  }

  public function to(array $to){
    array_map(function(Eduzz\ContactCenter\Entities\Person $person) {
      $this->to[] = $person->toArray();
    }, $to);
    return $this;
  }

  public function cc(array $cc){
    $this->cc = $cc;
    return $this;
  }

  public function bcc(array $bcc){
    $this->bcc = $bcc;
    return $this;
  }

  public function replyTo(string $email, string $name = null){
    
    $replyTo['email'] = $email;
    if ($name)
      $replyTo['name'] = $name;

    $this->replyTo = $replyTo;
    return $this;

  }

  public function from(string $email, string $name = null){
    $from['email'] = $email;
    if ($name)
      $from['name'] = $name;

    $this->from = (object)$from;

    return $this;
  }

  public function params($params){
    $this->params = $params;
    return $this;
  }

  public function subject($subject){
    $this->subject = $subject;
    return $this;
  }

  private function prepareData() {

    $data['template_id'] = $this->template;

    if ($this->subject)
      $data['subject'] = $this->subject;
    
    if (count($this->to) > 0)
      $data['to'] = $this->to;

    if (count($this->cc) > 0)
      $data['cc'] = $this->cc;

    if (count($this->bcc) > 0)
      $data['bcc'] = $this->bcc;

    if ($this->from)
      $data['from'] = $this->from;

    if ($this->replyTo)
      $data['reply_to'] = $this->replyTo;

    if ($this->params)
      $data['params'] = $this->params;

    if ($this->metadata)
      $data['_metadata'] = $this->metadata;
    
    return $data;
  }


  public function send() {
    try {

      $response = $this->clientHttp->request('POST', 
                                         $this->config->baseUrl . '/send/email',
                                        [
                                          'json' => $this->prepareData()
                                        ]);

      echo json_encode($this->prepareData());

      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      if ($this->callbackError)
        return $this->callbackError->call($this, $e, $this->prepareData());

      throw $this->formatException($e);
    }

  }

}