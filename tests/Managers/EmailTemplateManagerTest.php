<?php

namespace Eduzz\ContactCenter\Tests\Managers;

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Eduzz\ContactCenter\Tests\APIResponses\EmailTemplateResponse;
use Eduzz\ContactCenter\Managers\EmailTemplateManager;
use Eduzz\ContactCenter\Exceptions\UnexpectedApiException;
use Eduzz\ContactCenter\Exceptions\ValidationException;

class EmailTemplateManagerTest extends TestCase
{
    
    private $clientHttp;

    private $responseData;

    public function setUp()
    {
      $this->responseData = new EmailTemplateResponse();
    }

    private function mockClientHttp($code, $desireResponse) {

      $mockResponse = new MockHandler([new Response($code, [], $desireResponse)]);
      $mockHandler = HandlerStack::create($mockResponse);
      $this->clientHttp = new Client(['handler' => $mockHandler, 'headers' => [
        'applicationKey' => 'teste'
      ]]);

    }

    public function testListEmailTemplatesWhenApiIsOk()
    {
      $this->mockClientHttp(200, json_encode($this->responseData->listResponse()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->list();

      $this->assertEquals('5ca4dd48cf621300ae192cbe', $response->data[0]->_id);
      $this->assertEquals([], $response->data[0]->body->params);
      $this->assertEquals('Olá {{ nome }}, bem vindo(a)', $response->data[0]->body->raw);
      $this->assertEquals('ACTIVE', $response->data[0]->status);
      
    }

    public function testListEmailTemplatesWhenApiIsDown()
    {
      $this->expectException(UnexpectedApiException::class);

      $this->mockClientHttp(500, json_encode($this->responseData->listResponse()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->list();

    }

    public function testListEmailTemplatesWhenValidationAPIReturnError()
    {
      $this->expectException(ValidationException::class);

      $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->list();

    }


    public function testGetEmailTemplatesWhenApiIsOk()
    {
      $this->mockClientHttp(200, json_encode($this->responseData->getResponse()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->get('5ca4dd48cf621300ae192cbe');

      $this->assertEquals('5ca4dd48cf621300ae192cbe', $response->_id);
      $this->assertEquals([], $response->body->params);
      $this->assertEquals('Olá {{ nome }}, bem vindo(a)', $response->body->raw);
      $this->assertEquals('ACTIVE', $response->status);
      
    }

    public function testGetEmailTemplatesWhenApiIsDown()
    {
      $this->expectException(UnexpectedApiException::class);

      $this->mockClientHttp(500, '');

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->get('5ca4dd48cf621300ae192cbe');

    }

    public function testGetEmailTemplatesWhenValidationAPIReturnError()
    {
      $this->expectException(ValidationException::class);

      $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->get('5ca4dd48cf621300ae192cbe');

    }

    public function testUpdateEmailTemplatesWhenApiIsOk()
    {
      $this->mockClientHttp(200, json_encode($this->responseData->updateResponse()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->update('5ca4dd48cf621300ae192cbe', 'Assunto do e-mail', [], '');

      $this->assertEquals('5ca4dd48cf621300ae192cbe', $response->_id);
      $this->assertEquals([], $response->body->params);
      $this->assertEquals('Olá {{ nome }}, bem vindo(a)', $response->body->raw);
      $this->assertEquals('ACTIVE', $response->status);
      
    }

    public function testUpdateEmailTemplatesWhenApiIsDown()
    {
      $this->expectException(UnexpectedApiException::class);

      $this->mockClientHttp(500, '');

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->update('5ca4dd48cf621300ae192cbe', 'Assunto do e-mail', [], '');

    }

    public function testUpdateEmailTemplatesWhenValidationAPIReturnError()
    {
      $this->expectException(ValidationException::class);

      $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->update('5ca4dd48cf621300ae192cbe', 'Assunto do e-mail', [], '');

    }


    public function testCreateEmailTemplatesWhenApiIsOk()
    {
      $this->mockClientHttp(200, json_encode($this->responseData->createResponse()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->create('Assunto do e-mail', [], '');

      $this->assertEquals('5ca4dd48cf621300ae192cbe', $response->_id);
      $this->assertEquals([], $response->body->params);
      $this->assertEquals('Olá {{ nome }}, bem vindo(a)', $response->body->raw);
      $this->assertEquals('ACTIVE', $response->status);
      
    }

    public function testCreateEmailTemplatesWhenApiIsDown()
    {
      $this->expectException(UnexpectedApiException::class);

      $this->mockClientHttp(500, '');

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->create('Assunto do e-mail', [], '');

    }

    public function testCreateEmailTemplatesWhenValidationAPIReturnError()
    {
      $this->expectException(ValidationException::class);

      $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->create('Assunto do e-mail', [], '');

    }


    public function testDeleteEmailTemplatesWhenApiIsOk()
    {
      $this->mockClientHttp(200, json_encode($this->responseData->deleteResponse()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->delete('5ca4dd48cf621300ae192cbe');

      $this->assertEquals('5ca4dd48cf621300ae192cbe', $response->_id);
      
    }

    public function testDeleteEmailTemplatesWhenApiIsDown()
    {
      $this->expectException(UnexpectedApiException::class);

      $this->mockClientHttp(500, '');

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->delete('5ca4dd48cf621300ae192cbe');

    }

    public function testDeleteEmailTemplatesWhenValidationAPIReturnError()
    {
      $this->expectException(ValidationException::class);

      $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

      $emailTemplateManager = new EmailTemplateManager($this->clientHttp);

      $response = $emailTemplateManager->delete('5ca4dd48cf621300ae192cbe');

    }



    public function tearDown()
    {

    }

}
