<?php

namespace Eduzz\ContactCenter;

use Eduzz\ContactCenter\Managers\DeliveryManager;
use Eduzz\ContactCenter\Managers\EmailTemplateManager;
use Eduzz\ContactCenter\Managers\ReportManager;
use Eduzz\ContactCenter\Managers\SMSTemplateManager;
use Eduzz\ContactCenter\Messages\EmailMessage;
use Eduzz\ContactCenter\Messages\SMSMessage;
use GuzzleHttp\Client;

class ContactCenter
{

    private $config;
    private $clientHttp;
    private $deliveryManager;
    private $reportManager;
    private $emailTemplateManager;
    private $smsTemplateManager;

    public function __construct($config = null)
    {
        $this->config     = (object) $config;
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

    private function initReportManager()
    {
        $manager = new ReportManager($this->getClientHttp());
        $manager->setConfig($this->config);
        return $manager;
    }

    private function getClientHttp()
    {
        if (!$this->clientHttp) {
            $this->clientHttp = new Client([
                'headers' => [
                    'applicationKey' => $this->config->applicationKey,
                ],
            ]);
        }

        return $this->clientHttp;
    }

    public function delivery()
    {
        if (!$this->deliveryManager) {
            $this->deliveryManager = $this->initDeliveryManager();
        }

        return $this->deliveryManager;
    }

    public function reports()
    {
        if (!$this->reportManager) {
            $this->reportManager = $this->initReportManager();
        }

        return $this->reportManager;
    }

    public function smsTemplates()
    {
        if (!$this->smsTemplateManager) {
            $this->smsTemplateManager = $this->initSMSTemplateManager();
        }

        return $this->smsTemplateManager;
    }

    public function emailTemplates()
    {
        if (!$this->emailTemplateManager) {
            $this->emailTemplateManager = $this->initEmailTemplateManager();
        }

        return $this->emailTemplateManager;
    }

    public function createEmailMessage() : EmailMessage
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

}
