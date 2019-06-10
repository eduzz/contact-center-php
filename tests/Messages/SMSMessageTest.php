<?php

namespace Eduzz\ContactCenter\Tests\Messages;

use PHPUnit\Framework\TestCase;

use Eduzz\ContactCenter\Messages\SMSMessage;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Eduzz\ContactCenter\Exceptions\ValidationException;
use Eduzz\ContactCenter\Exceptions\UnexpectedApiException;
use Eduzz\ContactCenter\Entities\Phone;

class SMSMessageTest extends TestCase
{
    
    private $clientHttp;

    private function mockClientHttp($code, $desireResponse) {

      $mockResponse = new MockHandler([new Response($code, [], $desireResponse)]);
      $mockHandler = HandlerStack::create($mockResponse);
      $this->clientHttp = new Client(['handler' => $mockHandler, 'headers' => [
        'applicationKey' => 'teste'
      ]]);

    }

    public function setUp()
    { 
        
    }

    public function testSendWithoutScheduleField()
    {
      
      $this->mockClientHttp(200, json_encode([
        'subject' => 'Enviado com sucesso',
        '_id' => 'hash',
      ]));

      $smsMessage = new SMSMessage($this->clientHttp);

      $response = $smsMessage->to([
        (new Phone('+55', '15', '999999999'))->toArray()
      ])
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->template('tetetetetete')
      ->metadata([
        '_id' => '99999'
      ])
      ->send();
      
      $this->assertEquals('hash', $response->_id);

    }

    public function testSendWithScheduleField()
    {
      
      $this->mockClientHttp(200, json_encode([
        'subject' => 'Enviado com sucesso',
        '_id' => 'hash',
      ]));

      $smsMessage = new SMSMessage($this->clientHttp);

      $response = $smsMessage->to([
        (new Phone('+55', '15', '999999999'))
      ])
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->template('tetetetetete')
      ->schedule(time())
      ->send();
      
      $this->assertEquals('hash', $response->_id);

    }


    public function testValidationExceptionOnCallAPI()
    {
      
      $this->expectException(ValidationException::class);

      $this->mockClientHttp(400, json_encode([
        'error' => true, 
        'code' => 100,
        'message' => 'Erro de validacao'
      ]));

      $smsMessage = new SMSMessage($this->clientHttp);

      $response = $smsMessage->to([
        (new Phone('+55', '15', '999999999'))
      ])
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->template('tetetetetete')
      ->send();

    }

    public function testExceptionWhenAPIIsDown()
    {
      
      $this->expectException(UnexpectedApiException::class);

      $this->mockClientHttp(500, json_encode([
        'error' => true, 
        'code' => 200,
        'message' => 'Erro de validacao'
      ]));

      $smsMessage = new SMSMessage($this->clientHttp);

      $response = $smsMessage->to([
        (new Phone('+55', '15', '999999999'))
      ])
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->template('tetetetetete')
      ->send();

    }

    public function testExceptionWhenAPIIsDownWithCustomCallback()
    {
      
      $this->mockClientHttp(500, json_encode([
        'error' => true, 
        'code' => 200,
        'message' => 'Erro de validacao'
      ]));
      $context = $this;

      $smsMessage = new SMSMessage($this->clientHttp);

      $response = $smsMessage->to([
        (new Phone('+55', '15', '999999999'))
      ])
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->onError(function ($ex, $data) use ($context) {
        $context->assertTrue(true);
      })
      ->template('tetetetetete')
      ->send();
    }

    public function tearDown()
    {

    }

}
