<?php

namespace Eduzz\ContactCenter\Tests\Messages;

use Eduzz\ContactCenter\Entities\Person;
use Eduzz\ContactCenter\Exceptions\UnexpectedApiException;
use Eduzz\ContactCenter\Exceptions\ValidationException;
use Eduzz\ContactCenter\Messages\EmailMessage;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class EmailMessageTest extends TestCase
{

    private $clientHttp;

    private function mockClientHttp($code, $desireResponse)
    {

        $mockResponse     = new MockHandler([new Response($code, [], $desireResponse)]);
        $mockHandler      = HandlerStack::create($mockResponse);
        $this->clientHttp = new Client(['handler' => $mockHandler, 'headers' => [
            'applicationKey' => 'teste',
        ]]);

    }

    public function setUp()
    {

    }

    public function testSendWithoutScheduleField()
    {

        $this->mockClientHttp(200, json_encode([
            'subject' => 'Enviado com sucesso',
            '_id'     => 'hash',
        ]));

        $emailMessage = new EmailMessage($this->clientHttp);

        $response = $emailMessage->to([
            (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
        ])
            ->from('phpunit@php.com', 'PHPUnit')
            ->cc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->bcc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->replyTo('teste@phpunit.com', 'Teste')
            ->params([
                'nome' => 'PHPUnit',
            ])
            ->subject('Teste feito pelo PHPUnit')
            ->onError(function ($e) {
                echo "Erro encontrado";
            })
            ->template('tetetetetete')
            ->metadata([
                '_id' => '99999',
            ])
            ->send();

        $this->assertEquals('hash', $response->_id);

    }

    public function testSendWithScheduleField()
    {

        $this->mockClientHttp(200, json_encode([
            'subject' => 'Enviado com sucesso',
            '_id'     => 'hash',
        ]));

        $emailMessage = new EmailMessage($this->clientHttp);

        $response = $emailMessage->to([
            (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
        ])
            ->from('phpunit@php.com', 'PHPUnit')
            ->cc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->bcc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->replyTo('teste@phpunit.com', 'Teste')
            ->params([
                'nome' => 'PHPUnit',
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
            'error'   => true,
            'code'    => 100,
            'message' => 'Erro de validacao',
        ]));

        $emailMessage = new EmailMessage($this->clientHttp);

        $response = $emailMessage->to([
            (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
        ])
            ->from('phpunit@php.com', 'PHPUnit')
            ->cc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->bcc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->replyTo('teste@phpunit.com', 'Teste')
            ->params([
                'nome' => 'PHPUnit',
            ])
            ->subject('Teste feito pelo PHPUnit')
            ->send();

    }

    public function testExceptionWhenAPIIsDownWithNoCustomCallback()
    {

        $this->expectException(UnexpectedApiException::class);

        $this->mockClientHttp(500, json_encode([
            'error'   => true,
            'code'    => 200,
            'message' => 'Erro de validacao',
        ]));

        $called = false;

        $emailMessage = new EmailMessage($this->clientHttp);

        $response = $emailMessage->to([
            (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
        ])
            ->from('phpunit@php.com', 'PHPUnit')
            ->cc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->bcc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->replyTo('teste@phpunit.com', 'Teste')
            ->params([
                'nome' => 'PHPUnit',
            ])
            ->subject('Teste feito pelo PHPUnit')
            ->send();

    }

    public function testExceptionWhenAPIIsDownWithCustomCallback()
    {

        //$this->expectException(UnexpectedApiException::class);
        $eumes = $this;
        $this->mockClientHttp(500, json_encode([
            'error'   => true,
            'code'    => 200,
            'message' => 'Erro de validacao',
        ]));

        $called = false;

        $emailMessage = new EmailMessage($this->clientHttp);

        $response = $emailMessage->to([
            (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
        ])
            ->from('phpunit@php.com', 'PHPUnit')
            ->cc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->bcc([
                (new Person('teste@unitario.com', 'Teste Unitario'))->toArray(),
            ])
            ->replyTo('teste@phpunit.com', 'Teste')
            ->params([
                'nome' => 'PHPUnit',
            ])
            ->onError(function ($e, $data) use ($eumes) {
                $called = true;
                $eumes->assertNotEmpty($e->getMessage());
                $eumes->assertTrue($called);
            })
            ->subject('Teste feito pelo PHPUnit')
            ->send();

    }

    public function tearDown()
    {

    }

}
