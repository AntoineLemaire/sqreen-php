<?php

namespace Sqreen;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Console\Application;
use function GuzzleHttp\Psr7\stream_for;

class SqreenClient
{
    const BASE_URI = 'bff.sqreen.io/dashboard/v0/';

    /**
     * @var Application
     */
    public $application;

    /**
     * @var SqreenSession
     */
    private $session;

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var string
     */
    private $sessionToken;

    /**
     * @var string
     */
    private $applicationId;

    /**
     * SqreenClient constructor.
     *
     * @param string $applicationId
     * @param string $login
     * @param string $password
     */
    public function __construct($applicationId, $login, $password)
    {
        $this->applicationId = $applicationId;

        $this->setDefaultClient();

        $this->session     = new SqreenSession($this, $login, $password);
        $this->application = new SqreenApplication($this);

        $this->authenticate();
    }

    /**
     * @return string
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * Sends POST request to Sqreen API.
     *
     * @param string $endpoint
     * @param array  $datas
     * @param bool   $anonymous
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public function post($endpoint, $datas = [], $anonymous = false)
    {
        $headers = ['Accept' => 'application/json'];
        if (!$anonymous) {
            $headers['x-user'] = $this->sessionToken;
        }

        $response = $this->httpClient->request('POST', $this->getUri().$endpoint, [
            'json'    => $datas,
            'headers' => $headers,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Sends PUT request to Sqreen API.
     *
     * @param string $endpoint
     * @param array  $datas
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public function put($endpoint, $datas = [])
    {
        $response = $this->httpClient->request('PUT', $this->getUri().$endpoint, [
            'json'    => $datas,
            'headers' => [
                'Accept' => 'application/json',
                'x-user' => $this->sessionToken,
            ],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Sends DELETE request to Sqreen API.
     *
     * @param string $endpoint
     * @param array  $datas
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public function delete($endpoint, $datas = [])
    {
        $response = $this->httpClient->request('DELETE', $this->getUri().$endpoint, [
            'json'    => $datas,
            'headers' => [
                'Accept' => 'application/json',
                'x-user' => $this->sessionToken,
            ],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * @param string $endpoint
     * @param array  $$datas
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public function get($endpoint, $datas = [])
    {
        $response = $this->httpClient->request('GET', $this->getUri().$endpoint, [
            'query'   => $datas,
            'headers' => [
                'Accept' => 'application/json',
                'x-user' => $this->sessionToken,
            ],
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Returns Sqreen API Uri.
     *
     * @return string
     */
    public function getUri()
    {
        return 'https://'.self::BASE_URI;
    }

    private function setDefaultClient()
    {
        $this->httpClient = new Client();
    }

    private function authenticate()
    {
        $this->sessionToken = $this->session->getSessionToken();
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    private function handleResponse(ResponseInterface $response)
    {
        $stream = stream_for($response->getBody());
        $data   = json_decode($stream);

        return $data;
    }
}
