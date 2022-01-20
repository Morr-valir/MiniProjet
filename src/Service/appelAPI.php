<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class appelAPI{

    private $concession;
    public function __construct(HttpClientInterface $concession)
    {
     $this->concession = $concession;
    }


    public function getConcessionnaire(): array
    {
        $response = $this->concession->request(
            'GET',
            'http://localhost:8000/api/clients'
        );

        return $response->toArray();
    }
}