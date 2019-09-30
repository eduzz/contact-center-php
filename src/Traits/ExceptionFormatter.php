<?php

namespace Eduzz\ContactCenter\Traits;

use Eduzz\ContactCenter\Exceptions\UnexpectedApiException;
use Eduzz\ContactCenter\Exceptions\ValidationException;
use GuzzleHttp\Exception\BadResponseException;

trait ExceptionFormatter
{
    protected function formatException($exception)
    {

        if ($exception instanceof BadResponseException) {

            if ($exception->hasResponse()) {
                $response = $exception->getResponse();

                $code         = $response->getStatusCode();
                $responseBody = json_decode($response->getBody());

                if (!$responseBody) {
                    return new UnexpectedApiException($exception->getMessage());
                }

                if ($code >= 400 && $code < 500) {
                    return new ValidationException($responseBody->message ?? 'Validation Error: empty message');
                } else {
                    return new UnexpectedApiException($responseBody->message ?? 'Unexpected API Error: empty message');
                }
            } else {
                return new UnexpectedApiException($exception->getMessage());
            }
        } else {
            return new UnexpectedApiException($exception->getMessage());
        }
    }
}
