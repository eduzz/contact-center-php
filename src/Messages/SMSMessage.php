<?php

namespace Eduzz\ContactCenter\Messages;

use Eduzz\ContactCenter\Entities\Phone;
use Eduzz\ContactCenter\Traits\Configuration;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SMSMessage extends Message
{

    use Configuration;

    private $params;
    private $to;

    public function __construct(Client $clientHttp)
    {
        $this->clientHttp = $clientHttp;

        $this->params = [];
        $this->to     = [];
    }

    public function params($params)
    {
        $this->params = $params;
        return $this;
    }

    public function to(array $to)
    {
        array_map(function (Phone $phone) {
            $this->to[] = $phone->toArray();
        }, $to);
        return $this;
    }

    private function prepareData()
    {
        $data['template_id'] = $this->template;

        if (count($this->to) > 0) {
            $data['to'] = $this->to;
        }

        if ($this->params) {
            $data['params'] = $this->params;
        }

        if ($this->metadata) {
            $data['_metadata'] = $this->metadata;
        }

        return $data;
    }

    public function send()
    {
        try {

            $response = $this->clientHttp->request(
                'POST',
                $this->config->baseUrl . '/send/sms',
                [
                    'json' => $this->prepareData(),
                ]
            );

            return json_decode($response->getBody());
        } catch (GuzzleException $e) {

            if ($this->callbackError) {
                return $this->callbackError->call($this, $e, $this->prepareData());
            }

            throw $this->formatException($e);
        }
    }
}
