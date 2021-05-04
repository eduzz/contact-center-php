<?php

namespace Eduzz\ContactCenter\Messages;

use Eduzz\ContactCenter\Consts\EmailPriorityType;
use Eduzz\ContactCenter\Entities\Person;
use Eduzz\ContactCenter\Entities\Postback;
use Eduzz\ContactCenter\Exceptions\ValidationException;
use Eduzz\ContactCenter\Messages\Message;
use Eduzz\ContactCenter\Traits\Configuration;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EmailMessage extends Message
{

    use Configuration;

    private $to;
    private $cc;
    private $bcc;
    private $replyTo;
    private $from;
    private $params;
    private $subject;
    private $postback;
    private $priority;
    private $type;

    public function __construct(Client $clientHttp)
    {
        $this->clientHttp = $clientHttp;

        $this->from     = null;
        $this->params   = [];
        $this->subject  = null;
        $this->to       = [];
        $this->cc       = [];
        $this->bcc      = [];
        $this->replyTo  = null;
        $this->postback = null;
        $this->priority = EmailPriorityType::MEDIUM;
    }

    /**
     * @param Person[] $to
     */
    public function to(array $to)
    {
        $this->to = array_merge($this->to, $to);
        return $this;
    }

    public function cc(array $cc)
    {
        $this->cc = $cc;
        return $this;
    }

    public function bcc(array $bcc)
    {
        $this->bcc = $bcc;
        return $this;
    }

    public function replyTo(string $email, string $name = null)
    {

        $replyTo['email'] = $email;
        if ($name) {
            $replyTo['name'] = $name;
        }

        $this->replyTo = $replyTo;
        return $this;
    }

    public function from(string $email, string $name = null)
    {
        $from['email'] = $email;
        if ($name) {
            $from['name'] = $name;
        }

        $this->from = (object) $from;

        return $this;
    }

    public function params($params)
    {
        $this->params = $params;
        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function postback(Postback $postback)
    {
        $this->postback = $postback;
        return $this;
    }

    public function marketing()
    {
        $this->type = 'marketing';
        return $this;
    }

    public function access()
    {
        $this->type = 'access';
        return $this;
    }

    public function priority(string $priority = EmailPriorityType::MEDIUM)
    {
        if (!in_array($priority, EmailPriorityType::getTypes())) {
            throw new ValidationException('The priority must be ' . implode(',', EmailPriorityType::getTypes()));
        }

        $this->priority = $priority;
        return $this;
    }

    private function prepareData()
    {
        $data['template_id'] = $this->template;

        if ($this->subject) {
            $data['subject'] = $this->subject;
        }

        if (count($this->to) > 0) {
            $data['to'] = $this->to;
        }

        if (count($this->cc) > 0) {
            $data['cc'] = $this->cc;
        }

        if (count($this->bcc) > 0) {
            $data['bcc'] = $this->bcc;
        }

        if ($this->from) {
            $data['from'] = $this->from;
        }

        if ($this->replyTo) {
            $data['reply_to'] = $this->replyTo;
        }

        if ($this->params) {
            $data['params'] = $this->params;
        }

        if ($this->metadata) {
            $data['_metadata'] = $this->metadata;
        }

        if ($this->postback) {
            $data['postback'] = $this->postback;
        }

        if ($this->type) {
            $data['type'] = $this->type;
        }

        $data['priority'] = $this->priority;

        return $data;
    }

    public function send()
    {
        try {

            $response = $this->clientHttp->request(
                'POST',
                $this->config->baseUrl . '/send/email',
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

    public function asyncSend()
    {
        try {

            $response = $this->clientHttp->request(
                'POST',
                $this->config->baseUrl . '/send/async-email',
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
