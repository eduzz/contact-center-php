<?php

namespace Eduzz\ContactCenter\Tests\APIResponses;

class SMSTemplateResponse
{

    public function listResponse()
    {
        return [
            'data' => [
                [
                    'body'   => [
                        'params' => [],
                        'raw'    => 'SMS de envio de testes',
                    ],
                    '_id'    => '5ca4ff1d059cd300af020116',
                    'status' => 'ACTIVE',
                    '__v'    => 0,
                ],
                [
                    'body'   => [
                        'params' => [],
                        'raw'    => 'SMS de envio de testes',
                    ],
                    '_id'    => '5ca4ff1d059cd300af020116',
                    'status' => 'ACTIVE',
                    '__v'    => 0,
                ],
            ],
        ];
    }

    public function getResponse()
    {
        return (object) [
            'body'   => [
                'params' => [],
                'raw'    => 'SMS de envio de testes',
            ],
            '_id'    => '5ca4ff1d059cd300af020116',
            'status' => 'ACTIVE',
            '__v'    => 0,
        ];
    }

    public function updateResponse()
    {
        return (object) [
            'body'   => [
                'params' => [],
                'raw'    => 'SMS de envio de testes',
            ],
            '_id'    => '5ca4ff1d059cd300af020116',
            'status' => 'ACTIVE',
            '__v'    => 0,
        ];
    }

    public function deleteResponse()
    {
        return (object) [
            'body'   => [
                'params' => [],
                'raw'    => 'SMS de envio de testes',
            ],
            '_id'    => '5ca4ff1d059cd300af020116',
            'status' => 'ACTIVE',
            '__v'    => 0,
        ];
    }

    public function createResponse()
    {
        return (object) [
            'body'   => [
                'params' => [],
                'raw'    => 'SMS de envio de testes',
            ],
            '_id'    => '5ca4ff1d059cd300af020116',
            'status' => 'ACTIVE',
            '__v'    => 0,
        ];
    }

    public function validationError()
    {
        return [
            'error'   => true,
            'code'    => 111,
            'message' => 'Mensagem de erro da API',
        ];
    }

}
