<?php

declare(strict_types=1);

namespace App\Gateway;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbApiGateway
{
    private HttpClientInterface $httpClient;
    private string $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function requestMovieByImdbId(?string $imdbId): array
    {
        if($imdbId === null) {
            return [];
        }

        return $this->requestApi('i='.$imdbId);
    }

    public function searchForMovieIdByTitle(string $title): ?string
    {
        $movie = $this->requestApi('t='.$title);
        return isset($movie['imdbID']) ? $movie['imdbID'] : null;
    }

    private function requestApi(string $queryString): array
    {
        $apiResponse = $this->httpClient->request(
            'GET',
            'http://www.omdbapi.com/?apikey='.$this->apiKey.'&'.$queryString
        );
        return $apiResponse->toArray();
    }
}
