<?php

namespace Eduzz\ContactCenter\Managers;

use Eduzz\ContactCenter\Traits\Configuration;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EmailTemplateManager extends Manager
{

    use Configuration;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    function list() {
        try {

            $response = $this->client->request('GET',
                $this->config->baseUrl . '/email/templates');

            return json_decode($response->getBody());

        } catch (GuzzleException $e) {

            throw $this->formatException($e);
        }

    }

    /**
     * Retorna um template específico
     *
     * @param string $id Id do template (obrigatório)
     * @return void
     */
    public function get($id)
    {
        try {
            $response = $this->client->request('GET',
                $this->config->baseUrl . '/email/templates/' . $id);

            return json_decode($response->getBody());

        } catch (GuzzleException $e) {

            throw $this->formatException($e);

        }

    }

    /**
     * Realiza a atualização de um template
     *
     * @param string $id Identificacao do template (obrigatório)
     * @param string $subject Assunto do template (obrigatório)
     * @param array(string) $to Identificacao do template (obrigatório)
     * @param string $bodyRaw HTML do template (obrigatório)
     * @param string $status Status
     * @param array $metadata Dados adicionais para acompanhamento
     * @return void
     */
    public function update($id, $subject, $to, $bodyRaw, $status = 'ACTIVE', $metadata = null)
    {

        try {

            $response = $this->client->request('PUT',
                $this->config->baseUrl . '/email/templates/' . $id,
                [
                    'json' => [
                        "subject"   => $subject,
                        "status"    => $status,
                        "to"        => $to,
                        "body"      => [
                            "raw" => $bodyRaw,
                        ],
                        "_metadata" => $metadata,
                    ],
                ]);
            return json_decode($response->getBody());

        } catch (GuzzleException $e) {

            throw $this->formatException($e);

        }

    }

    public function create($subject, $to, $bodyRaw, $status = 'ACTIVE', $metadata = null)
    {
        try {
            $response = $this->client->request('POST',
                $this->config->baseUrl . '/email/templates/',
                [
                    'json' => [
                        "subject"   => $subject,
                        "status"    => $status,
                        "to"        => $to,
                        "body"      => [
                            "raw" => $bodyRaw,
                        ],
                        "_metadata" => $metadata,
                    ],
                ]);

            return json_decode($response->getBody());

        } catch (GuzzleException $e) {

            throw $this->formatException($e);

        }

    }

    public function delete($id)
    {
        try {

            $response = $this->client->request('DELETE',
                $this->config->baseUrl . '/email/templates/' . $id);

            return json_decode($response->getBody());

        } catch (GuzzleException $e) {

            throw $this->formatException($e);

        }
    }

}
