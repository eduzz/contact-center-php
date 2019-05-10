<?php

namespace Eduzz\ContactCenter\Managers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Eduzz\ContactCenter\Config;
use Eduzz\ContactCenter\Traits\Configuration;

class SMSTemplateManager extends Manager
{

  use Configuration;

  public function __construct(Client $client) {
    $this->client = $client;
  }

  public function list() {
    try {
      
      $response = $this->client->request('GET', 
                                       $this->config->baseUrl . '/sms/templates');

      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      throw $this->formatException($e);
    }

  }

  /**
   * Retorna um template específico
   *
   * @param string $id Id do template (obrigatório)
   * @return void
   */
  public function get($id) {
    try {
      $response = $this->client->request('GET', 
                                         $this->config->baseUrl . '/sms/templates/' . $id);

      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      throw $this->formatException($e);

    }
    
  }

  /**
   * Realiza a atualização de um template
   *
   * @param string $id Identificacao do template (obrigatório)
   * @param string $subject Assunto do template (obrigatório)
   * @param array(string) $to Identificacao do template (obrigatório)
   * @param string $bodyRaw HTML do template (obrigatório)
   * @param string $status Status
   * @param array $metadata Dados adicionais para acompanhamento
   * @return void
   */
  public function update($id, $bodyRaw, $status = 'ACTIVE', $metadata = null) {

    try {

      $response = $this->client->request('PUT', 
                                        $this->config->baseUrl . '/sms/templates/' . $id, 
                                        [
                                          'json'=> [
                                              "status" => $status,
                                              "body" => [
                                                "raw" => $bodyRaw
                                              ],
                                              "_metadata" => $metadata
                                            ]
                                        ]);
      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      throw $this->formatException($e);

    }
    
  }

  public function create($bodyRaw, $status = 'ACTIVE', $metadata = null) {
    try {
      $response = $this->client->request('POST', 
                                        $this->config->baseUrl . '/sms/templates/', 
                                        [
                                          'json'=> [
                                            "status" => $status,
                                            "body" => [
                                              "raw" => $bodyRaw
                                            ],
                                            "_metadata" => $metadata
                                          ]
                                        ]);
    
      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      throw $this->formatException($e);

    }
    
  }

  public function delete($id) {
    try {
      
      $response = $this->client->request('DELETE', 
                                         $this->config->baseUrl . '/sms/templates/' . $id);
  
      return json_decode($response->getBody());

    } catch (GuzzleException $e) {
      
      throw $this->formatException($e);

    }
  }

}