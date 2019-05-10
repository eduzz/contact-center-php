<?php

namespace Eduzz\ContactCenter\Tests\Managers;

use PHPUnit\Framework\TestCase;

use Eduzz\ContactCenter\Managers\DeliveryManager;
use Eduzz\ContactCenter\Messages\EmailMessage;
use Eduzz\ContactCenter\Messages\SMSMessage;

use Mockery as M;

class DeliveryManagerTest extends TestCase
{

    private $emailMessage;
    private $smsMessage;
    
    public function setUp()
    {
      $this->emailMessage = M::mock(EmailMessage::class);
      $this->smsMessage = M::mock(SMSMessage::class);
    }

    public function tearDown()
    {
      M::close();
    }

    public function testSendAListOfMessages()
    {
      
      $this->emailMessage
        ->shouldReceive('send')
        ->andReturn(['_id' => '5ca4dd48cf621300ae192cbe'])
        ->getMock();
    
      $deliveryManager = new DeliveryManager();
      
      $deliveryManager->addMessage($this->emailMessage);
      $deliveryManager->addMessage($this->emailMessage);
      $deliveryManager->addMessage($this->emailMessage);
      
      $deliveryManager->send();

      $this->assertTrue(true);

    }

    public function testSendASpecificMessage()
    {
      
      $this->emailMessage
        ->shouldReceive('send')
        ->andReturn(['_id' => '5ca4dd48cf621300ae192cbe'])
        ->getMock();
    
      $deliveryManager = new DeliveryManager();
      
      $deliveryManager->send($this->emailMessage);
      
      $this->assertTrue(true);

    }

    public function testClearMessages()
    {
      
      $this->emailMessage
        ->shouldReceive('send')
        ->andReturn(['_id' => '5ca4dd48cf621300ae192cbe'])
        ->getMock();
    
      $deliveryManager = new DeliveryManager();
      
      $deliveryManager->addMessage($this->emailMessage);
      
      $deliveryManager->clear();

      $this->assertTrue(true);

    }


    public function testSendEmailAndSMSMessages()
    {
      
      $this->emailMessage
        ->shouldReceive('send')
        ->andReturn(['_id' => '5ca4dd48cf621300ae192cbe'])
        ->getMock();

      $this->smsMessage
        ->shouldReceive('send')
        ->andReturn(['_id' => '5ca4dd48cf621300ae192cbe'])
        ->getMock();
    
      $deliveryManager = new DeliveryManager();
      
      $deliveryManager->addMessage($this->emailMessage);
      $deliveryManager->addMessage($this->smsMessage);
      
      $deliveryManager->send();

      $this->assertTrue(true);

    }


}
