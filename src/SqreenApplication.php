<?php

namespace Sqreen;

class SqreenApplication
{
    const BASE_ENDPOINT = 'applications/';

    /**
     * @var SqreenClient
     */
    private $client;

    /**
     * SqreenApplication constructor.
     *
     * @param SqreenClient $client
     */
    public function __construct(SqreenClient $client)
    {
        $this->client = $client;
    }

    /**
     * Remove a security response.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public function deleteSecurityResponse($id)
    {
        return $this->client->delete(self::BASE_ENDPOINT.$this->client->getApplicationId().'/security_responses/'.$id);
    }

    /**
     * @param int $limit
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public function getSecurityResponse($limit = 20)
    {
        return $this->client->get(
            self::BASE_ENDPOINT.$this->client->getApplicationId().'/security_responses/',
            [
                '_limit' => $limit,
            ]
        );
    }
}
