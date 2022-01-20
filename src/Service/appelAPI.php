<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class appelAPI{

    private $concession;
    public function __construct(HttpClientInterface $concession)
    {
     $this->concession = $concession;
    }


    public function getConcessionnaire(){
        $response = $this->concessionnaireAPI->request(
            'GET',
            'http://localhost:8000/api/concessionnaire_a_p_is?page=1'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        return $content;
    }
}