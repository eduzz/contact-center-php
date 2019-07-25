<?php

namespace Eduzz\ContactCenter\Tests\Managers;

use Eduzz\ContactCenter\Exceptions\UnexpectedApiException;
use Eduzz\ContactCenter\Exceptions\ValidationException;
use Eduzz\ContactCenter\Managers\SMSTemplateManager;
use Eduzz\ContactCenter\Tests\APIResponses\SMSTemplateResponse;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class SMSTemplateManagerTest extends TestCase
{

    private $clientHttp;

    private $responseData;

    public function setUp()
    {
        $this->responseData = new SMSTemplateResponse();
    }

    private function mockClientHttp($code, $desireResponse)
    {

        $mockResponse     = new MockHandler([new Response($code, [], $desireResponse)]);
        $mockHandler      = HandlerStack::create($mockResponse);
        $this->clientHttp = new Client(['handler' => $mockHandler, 'headers' => [
            'applicationKey' => 'teste',
        ]]);

    }

    public function testListSMSTemplatesWhenApiIsOk()
    {
        $this->mockClientHttp(200, json_encode($this->responseData->listResponse()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->list();

        $this->assertEquals('5ca4ff1d059cd300af020116', $response->data[0]->_id);
        $this->assertEquals([], $response->data[0]->body->params);
        $this->assertEquals('SMS de envio de testes', $response->data[0]->body->raw);
        $this->assertEquals('ACTIVE', $response->data[0]->status);

    }

    public function testListSMSTemplatesWhenApiIsDown()
    {
        $this->expectException(UnexpectedApiException::class);

        $this->mockClientHttp(500, json_encode($this->responseData->listResponse()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->list();

    }

    public function testListSMSTemplatesWhenValidationAPIReturnError()
    {
        $this->expectException(ValidationException::class);

        $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->list();

    }

    public function testGetSMSTemplatesWhenApiIsOk()
    {
        $this->mockClientHttp(200, json_encode($this->responseData->getResponse()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->get('5ca4ff1d059cd300af020116');

        $this->assertEquals('5ca4ff1d059cd300af020116', $response->_id);
        $this->assertEquals([], $response->body->params);
        $this->assertEquals('SMS de envio de testes', $response->body->raw);
        $this->assertEquals('ACTIVE', $response->status);

    }

    public function testGetSMSTemplatesWhenApiIsDown()
    {
        $this->expectException(UnexpectedApiException::class);

        $this->mockClientHttp(500, '');

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->get('5ca4ff1d059cd300af020116');

    }

    public function testGetSMSTemplatesWhenValidationAPIReturnError()
    {
        $this->expectException(ValidationException::class);

        $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->get('5ca4ff1d059cd300af020116');

    }

    public function testUpdateSMSTemplatesWhenApiIsOk()
    {
        $this->mockClientHttp(200, json_encode($this->responseData->updateResponse()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->update('5ca4ff1d059cd300af020116', 'SMS de envio de testes', 'ACTIVE');

        $this->assertEquals('5ca4ff1d059cd300af020116', $response->_id);
        $this->assertEquals([], $response->body->params);
        $this->assertEquals('SMS de envio de testes', $response->body->raw);
        $this->assertEquals('ACTIVE', $response->status);

    }

    public function testUpdateSMSTemplatesWhenApiIsDown()
    {
        $this->expectException(UnexpectedApiException::class);

        $this->mockClientHttp(500, '');

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->update('5ca4ff1d059cd300af020116', 'SMS de envio de testes', 'ACTIVE');

    }

    public function testUpdateSMSTemplatesWhenValidationAPIReturnError()
    {
        $this->expectException(ValidationException::class);

        $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->update('5ca4ff1d059cd300af020116', 'SMS de envio de testes', 'ACTIVE');

    }

    public function testCreateSMSTemplatesWhenApiIsOk()
    {
        $this->mockClientHttp(200, json_encode($this->responseData->createResponse()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->create('SMS de envio de testes', 'ACTIVE');

        $this->assertEquals('5ca4ff1d059cd300af020116', $response->_id);
        $this->assertEquals([], $response->body->params);
        $this->assertEquals('SMS de envio de testes', $response->body->raw);
        $this->assertEquals('ACTIVE', $response->status);

    }

    public function testCreateSMSTemplatesWhenApiIsDown()
    {
        $this->expectException(UnexpectedApiException::class);

        $this->mockClientHttp(500, '');

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->create('SMS de envio de testes', 'ACTIVE');

    }

    public function testCreateSMSTemplatesWhenValidationAPIReturnError()
    {
        $this->expectException(ValidationException::class);

        $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->create('SMS de envio de testes', 'ACTIVE');

    }

    public function testDeleteSMSTemplatesWhenApiIsOk()
    {
        $this->mockClientHttp(200, json_encode($this->responseData->deleteResponse()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->delete('5ca4ff1d059cd300af020116');

        $this->assertEquals('5ca4ff1d059cd300af020116', $response->_id);

    }

    public function testDeleteSMSTemplatesWhenApiIsDown()
    {
        $this->expectException(UnexpectedApiException::class);

        $this->mockClientHttp(500, '');

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->delete('5ca4ff1d059cd300af020116');

    }

    public function testDeleteSMSTemplatesWhenValidationAPIReturnError()
    {
        $this->expectException(ValidationException::class);

        $this->mockClientHttp(403, json_encode($this->responseData->validationError()));

        $smsTemplateManager = new SMSTemplateManager($this->clientHttp);

        $response = $smsTemplateManager->delete('5ca4ff1d059cd300af020116');

    }

    public function tearDown()
    {

    }

}
