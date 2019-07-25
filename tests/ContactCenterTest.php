<?php

namespace Eduzz\ContactCenter\Tests;

use Eduzz\ContactCenter\ContactCenter;
use Eduzz\ContactCenter\Managers\DeliveryManager;
use Eduzz\ContactCenter\Managers\EmailTemplateManager;
use Eduzz\ContactCenter\Managers\SMSTemplateManager;
use Eduzz\ContactCenter\Messages\EmailMessage;
use Eduzz\ContactCenter\Messages\SMSMessage;
use PHPUnit\Framework\TestCase;

class ContactCenterTest extends TestCase
{
    private $config;

    public function setUp()
    {
        $this->config = [
            'applicationKey' => 'teste',
            'baseUrl'        => 'http://localhost:3000',
        ];
    }

    public function tearDown()
    {

    }

    public function testInitiateContactCenterAndManagers()
    {
        $contactcenter = new ContactCenter($this->config);

        $this->assertInstanceOf(EmailTemplateManager::class, $contactcenter->emailTemplates());
        $this->assertInstanceOf(SMSTemplateManager::class, $contactcenter->smsTemplates());
        $this->assertInstanceOf(DeliveryManager::class, $contactcenter->delivery());
        $this->assertInstanceOf(EmailMessage::class, $contactcenter->createEmailMessage());
        $this->assertInstanceOf(SMSMessage::class, $contactcenter->createSMSMessage());

    }

}
