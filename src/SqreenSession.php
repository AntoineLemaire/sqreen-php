<?php

namespace Sqreen;

class SqreenSession
{
    const BASE_ENDPOINT = 'sessions/';

    /**
     * @var string Email authentication
     */
    protected $email;

    /**
     * @var string Password authentication
     */
    protected $password;

    /**
     * @var SqreenClient
     */
    private $client;

    /**
     * SqreenSession constructor.
     *
     * @param SqreenClient $client
     * @param string       $email
     * @param string       $password
     */
    public function __construct(SqreenClient $client, $email, $password)
    {
        $this->client   = $client;
        $this->email    = $email;
        $this->password = $password;
    }

    /**
     * Authenticate to get Session Token.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public function getSessionToken()
    {
        $result = $this->client->post(self::BASE_ENDPOINT, [
            'email'    => $this->email,
            'password' => $this->password,
        ], true);

        return $result->data;
    }
}
