<?php

namespace Eduzz\ContactCenter\Managers;

use Eduzz\ContactCenter\Entities\GetDeliveriesEmailFilter;
use Eduzz\ContactCenter\Entities\GetDeliveriesSMSFilter;
use Eduzz\ContactCenter\Traits\Configuration;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ReportManager extends Manager
{

    use Configuration;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getDeliveredEmail(GetDeliveriesEmailFilter $filter)
    {
        try {

            $response = $this->client->request('GET',
                $this->config->baseUrl . '/reports/deliveries/email',
                [
                    'json' => $filter->get(),
                ]);
            return json_decode($response->getBody());

        } catch (GuzzleException $e) {

            throw $this->formatException($e);

        }
    }

    public function getDeliveredSMS(GetDeliveriesSMSFilter $filter)
    {
        try {

            $response = $this->client->request('GET',
                $this->config->baseUrl . '/deliveries/sms',
                [
                    'json' => [
                        $filter->get(),
                    ],
                ]);
            return json_decode($response->getBody());

        } catch (GuzzleException $e) {

            throw $this->formatException($e);

        }

    }

}
