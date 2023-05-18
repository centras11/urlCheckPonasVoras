<?php

namespace App\Service\Checker\Handler;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class LinkCheckerResponseCode extends BaseLinkChecker
{
    const ACTION_NAME = 'action-response-code';

    /**
     * @throws TransportExceptionInterface
     */
    public function handleCheck(): string
    {
        $response = $this->client->request(
            'GET',
            $this->getLink()->getUrl()
        );

        return $response->getStatusCode();
    }
}