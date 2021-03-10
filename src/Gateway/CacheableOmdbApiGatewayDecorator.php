<?php

declare(strict_types=1);

namespace App\Gateway;


use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CacheableOmdbApiGatewayDecorator extends OmdbApiGateway
{
    private CacheInterface $cache;
    private OmdbApiGateway $actualGateway;

    public function __construct(CacheInterface $cache, OmdbApiGateway $actualGateway)
    {
        $this->cache = $cache;
        $this->actualGateway = $actualGateway;
    }

    public function requestMovieByImdbId(?string $imdbId): array
    {
        return $this->cache->get('movie_by_id_'.$imdbId, function(ItemInterface $item) use ($imdbId) {
            $item->expiresAfter(60);

            return $this->actualGateway->requestMovieByImdbId($imdbId);
        });
    }

    public function searchForMovieIdByTitle(string $title): ?string
    {
        return $this->cache->get('movie_id_by_title_'.md5($title), function(ItemInterface $item) use ($title) {
            $item->expiresAfter(60);

            return $this->actualGateway->searchForMovieIdByTitle($title);
        });
    }
}
