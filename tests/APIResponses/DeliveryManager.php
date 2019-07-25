<?php

namespace Eduzz\ContactCenter\Tests\APIResponses;

class DeliveryResponse
{

    public function validationError()
    {
        return [
            'error'   => true,
            'code'    => 111,
            'message' => 'Mensagem de erro da API',
        ];
    }

}
