<?php

namespace Eduzz\ContactCenter\Managers;

use Eduzz\ContactCenter\Traits\Configuration;
use Eduzz\ContactCenter\Entities\GetDeliveriesEmailFilter;
use Eduzz\ContactCenter\Entities\GetDeliveriesSMSFilter;

class ReportManager extends Manager
{

  use Configuration;

  public function __construct() {
    // Constructor 
  }

  public function getDeliveredEmail(GetDeliveriesEmailFilter $filter)
  {
    try {

      $response = $this->client->request('GET', 
                                        $this->config->baseUrl . '/deliveries/email', 
                                        [
                                          'json'=> [
                                              $filter->get()
                                            ]
                                        ]);
      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      throw $this->formatException($e);

    }
  }

  public function getDeliveredSMS(GetDeliveriesSMSFilter $filter)
  {
    try {

      $response = $this->client->request('GET', 
                                        $this->config->baseUrl . '/deliveries/sms', 
                                        [
                                          'json'=> [
                                              $filter->get()
                                            ]
                                        ]);
      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      throw $this->formatException($e);

    }
    
  }
  

}