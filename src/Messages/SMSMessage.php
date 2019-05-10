<?php

namespace Eduzz\ContactCenter\Messages;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Eduzz\ContactCenter\Traits\Configuration;

class SMSMessage extends Message
{

  use Configuration;

  private $params;
  private $to;
  
  public function __construct(Client $clientHttp) {
    $this->clientHttp = $clientHttp; 

    $this->params = [];
    $this->to = [];
  }

  public function params($params){
    $this->params = $params;
    return $this;
  }

  public function to(array $to){
    $this->to = $to;
    return $this;
  }

  private function prepareData() {
    $data['template_id'] = $this->template;

    if (count($this->to) > 0)
      $data['to'] = $this->to;

    if ($this->params)
      $data['params'] = $this->params;

    if ($this->metadata)
      $data['_metadata'] = $this->metadata;

    return $data;
  }

  public function send() {
    try {
      
      $response = $this->clientHttp->request('POST', 
                                         $this->config->baseUrl . '/send/sms',
                                        [
                                          'json' => $this->prepareData()
                                        ]);

      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      throw $this->formatException($e);

    }

  }

}