<?php

namespace Eduzz\ContactCenter\Traits;

use GuzzleHttp\Exception\BadResponseException;
use Eduzz\ContactCenter\Exceptions\UnexpectedApiException;
use Eduzz\ContactCenter\Exceptions\ValidationException;

trait ExceptionFormatter
{
  protected function formatException($exception)
  {
    
    if($exception instanceof BadResponseException) {
      
      if($exception->hasResponse()) {
          $response = $exception->getResponse();

          $code = $response->getStatusCode();
          $responseBody = json_decode($response->getBody());

          if(!$responseBody) {
              return new UnexpectedApiException($exception->getMessage());
          }

          $message = [
            'message' => $responseBody->message,
            'errors' => $responseBody->errors
          ];

          if($code >= 400 && $code < 500) {
              return new ValidationException(json_encode($message) ?? 'Validation Error: empty message');
          } else {
              return new UnexpectedApiException(json_encode($message) ?? 'Unexpected API Error: empty message');
          }

      } else {
          return new UnexpectedApiException($exception->getMessage());
      }
  } else {
    return new UnexpectedApiException($exception->getMessage());
  }

  }
}