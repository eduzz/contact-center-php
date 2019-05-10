<?php

namespace Eduzz\ContactCenter\Tests\APIResponses;

class EmailTemplateResponse
{
  
  public function listResponse()
  {
    return [
      'data' => [
        [
          'body' => [
            'params' => [],
            'raw' => 'Olá {{ nome }}, bem vindo(a)'
          ],
          '_id' => '5ca4dd48cf621300ae192cbe',
          'subject' => 'Assunto do e-mail',
          'status' => 'ACTIVE',
          'to' => [],
          '_metadata' => [
              'contentId' => 123
          ],
          '__v' => 0
        ],
        [
          'body' => [
            'params' => [],
            'raw' => 'Olá {{ nome }}, bem vindo(a)'
          ],
          '_id' => '5ca4dd48cf621300ae192cbe',
          'subject' => 'Assunto do e-mail',
          'status' => 'ACTIVE',
          'to' => [],
          '_metadata' => [
              'contentId' => 123
          ],
          '__v' => 0
        ]
      ]
    ];
  }

  public function getResponse()
  {
    return (object)[
            'body' => [
              'params' => [],
              'raw' => 'Olá {{ nome }}, bem vindo(a)'
            ],
            '_id' => '5ca4dd48cf621300ae192cbe',
            'subject' => 'Assunto do e-mail',
            'status' => 'ACTIVE',
            'to' => [],
            '_metadata' => [
                'contentId' => 123
            ],
            '__v' => 0
          ];
  }

  public function updateResponse()
  {
    return (object)[
          'body' => [
            'params' => [],
            'raw' => 'Olá {{ nome }}, bem vindo(a)'
          ],
          '_id' => '5ca4dd48cf621300ae192cbe',
          'subject' => 'Assunto do e-mail',
          'status' => 'ACTIVE',
          'to' => [],
          '_metadata' => [
              'contentId' => 123
          ],
          '__v' => 0
        ];
  }

  public function deleteResponse()
  {
    return (object)[
            'body' => [
              'params' => [],
              'raw' => 'Olá {{ nome }}, bem vindo(a)'
            ],
            '_id' => '5ca4dd48cf621300ae192cbe',
            'subject' => 'Assunto do e-mail',
            'status' => 'ACTIVE',
            'to' => [],
            '_metadata' => [
                'contentId' => 123
            ],
            '__v' => 0
          ];
  }

  public function createResponse()
  {
    return (object)[
      'body' => [
        'params' => [],
        'raw' => 'Olá {{ nome }}, bem vindo(a)'
      ],
      '_id' => '5ca4dd48cf621300ae192cbe',
      'subject' => 'Assunto do e-mail',
      'status' => 'ACTIVE',
      'to' => [],
      '_metadata' => [
          'contentId' => 123
      ],
      '__v' => 0
    ];
  }

  public function validationError()
  {
    return [
      'error' => true,
      'code' => 111,
      'message' => 'Mensagem de erro da API'
    ];
  }

}