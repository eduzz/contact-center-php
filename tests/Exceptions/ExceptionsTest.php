<?php

namespace Eduzz\ContactCenter\Tests\Managers;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;
use Eduzz\ContactCenter\Config;
use GuzzleHttp\Psr7\Response;
use Eduzz\ContactCenter\Messages\EmailMessage;
use Eduzz\ContactCenter\Entities\Person;
use Eduzz\ContactCenter\Exceptions\UnexpectedApiException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use Eduzz\ContactCenter\Traits\ExceptionFormatter;
use Eduzz\ContactCenter\Exceptions\ValidationException;

class ExceptionsTest extends TestCase
{

    use ExceptionFormatter;

    public function setUp()
    {
      
    }

    public function tearDown()
    {
      
    }

    private function mockClientHttp($code, $desireResponse) {
      $mockResponse = new MockHandler([new Response($code, [], $desireResponse)]);
      $mockHandler = HandlerStack::create($mockResponse);
      $this->clientHttp = new Client(['handler' => $mockHandler, 'headers' => [
        'applicationKey' => Config::APPLICATION_KEY
      ]]);
    }

    
    public function testTreatmentForUnknownExceptions()
    {
      $this->expectException(UnexpectedApiException::class);

      $mock = new MockHandler([ $this->formatException(new \Exception('teste')) ]);
      $handler = HandlerStack::create($mock);
      $this->clientHttp = new Client(['handler' => $handler, 'headers' => [
        'applicationKey' => 'teste'
      ]]);

      $emailMessage = new EmailMessage($this->clientHttp);

      $emailMessage->to([
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


    public function testTreatmentForBadRequestsWithoutResponse()
    {
      $this->expectException(UnexpectedApiException::class);

      $mock = new MockHandler([ 
        $this->formatException(new \GuzzleHttp\Exception\BadResponseException('teste', new Request('POST','/'))) 
      ]);
      $handler = HandlerStack::create($mock);
      $this->clientHttp = new Client(['handler' => $handler, 'headers' => [
        'applicationKey' => 'teste'
      ]]);

      $emailMessage = new EmailMessage($this->clientHttp);

      $emailMessage->to([
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

    public function testGetJSONErrorPresentation()
    {
      $exception = new ValidationException('Teste de apresentacao do exception', 200);

      $json = $exception->getJSON();

      $this->assertEquals(200, $json->code);
      $this->assertEquals('Teste de apresentacao do exception', $json->message);
    }


}
