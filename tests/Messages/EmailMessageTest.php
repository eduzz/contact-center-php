<?php

namespace Eduzz\ContactCenter\Tests\Messages;

use PHPUnit\Framework\TestCase;

use Eduzz\ContactCenter\Messages\EmailMessage;
use GuzzleHttp\Client;
use Eduzz\ContactCenter\Entities\Person;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Eduzz\ContactCenter\Exceptions\ValidationException;
use Eduzz\ContactCenter\Exceptions\UnexpectedApiException;

class EmailMessageTest extends TestCase
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

      $emailMessage = new EmailMessage($this->clientHttp);

      $response = $emailMessage->to([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->from('phpunit@php.com', 'PHPUnit')
      ->cc([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->bcc([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->replyTo('teste@phpunit.com', 'Teste')
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->subject('Teste feito pelo PHPUnit')
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

      $emailMessage = new EmailMessage($this->clientHttp);

      $response = $emailMessage->to([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->from('phpunit@php.com', 'PHPUnit')
      ->cc([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->bcc([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->replyTo('teste@phpunit.com', 'Teste')
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->subject('Teste feito pelo PHPUnit')
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

      $emailMessage = new EmailMessage($this->clientHttp);

      $response = $emailMessage->to([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->from('phpunit@php.com', 'PHPUnit')
      ->cc([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->bcc([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->replyTo('teste@phpunit.com', 'Teste')
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->subject('Teste feito pelo PHPUnit')
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

      $emailMessage = new EmailMessage($this->clientHttp);

      $response = $emailMessage->to([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->from('phpunit@php.com', 'PHPUnit')
      ->cc([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->bcc([
        (new Person('teste@unitario.com', 'Teste Unitario'))->toArray()
      ])
      ->replyTo('teste@phpunit.com', 'Teste')
      ->params([
        'nome' => 'PHPUnit'
      ])
      ->subject('Teste feito pelo PHPUnit')
      ->send();

    }

    public function tearDown()
    {

    }

}
