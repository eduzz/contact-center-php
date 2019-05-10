<?php

namespace Eduzz\ContactCenter;

use Eduzz\ContactCenter\Managers\DeliveryManager;
use Eduzz\ContactCenter\Managers\EmailTemplateManager;
use Eduzz\ContactCenter\Managers\SMSTemplateManager;
use GuzzleHttp\Client;
use Eduzz\ContactCenter\Messages\EmailMessage;
use Eduzz\ContactCenter\Messages\SMSMessage;

class ContactCenter
{

  private $config;

  private $clientHttp;

  private $deliveryManager;

  private $emailTemplateManager;

  private $smsTemplateManager;

  public function __construct($config = null)
  {
    $this->config = (object)$config;

    $this->deliveryManager = $this->initDeliveryManager();
    $this->emailTemplateManager = $this->initEmailTemplateManager();
    $this->smsTemplateManager = $this->initSMSTemplateManager();

    $this->clientHttp = $this->getClientHttp();
  }

  private function initDeliveryManager()
  {
    $manager = new DeliveryManager($this->getClientHttp());
    $manager->setConfig($this->config);
    return $manager;
  }

  private function initEmailTemplateManager()
  {
    $manager = new EmailTemplateManager($this->getClientHttp());
    $manager->setConfig($this->config);
    return $manager;
  }

  private function initSMSTemplateManager()
  {
    $manager = new SMSTemplateManager($this->getClientHttp());
    $manager->setConfig($this->config);
    return $manager;
  }

  public function delivery()
  {
    return $this->deliveryManager;
  }

  public function smsTemplates()
  {
    return $this->smsTemplateManager;
  }

  public function emailTemplates()
  {
    return $this->emailTemplateManager;
  }

  public function createEmailMessage()
  {
    $emailMessage = new EmailMessage($this->clientHttp);
    $emailMessage->setConfig($this->config);
    return $emailMessage;
  }

  public function createSMSMessage()
  {
    $smsMessage = new SMSMessage($this->clientHttp);
    $smsMessage->setConfig($this->config);
    return $smsMessage;
  }

  private function getClientHttp()
  {
    if (!$this->clientHttp)
      $this->clientHttp = new Client([ 
        'headers' => [
          'applicationKey' => $this->config->applicationKey
        ]
      ]);

    return $this->clientHttp;
  }

}