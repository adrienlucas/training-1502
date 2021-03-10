<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Movie;
use App\Gateway\OmdbApiGateway;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension /*implements ExtensionInterface*/
{
    private OmdbApiGateway $omdbApiGateway;

    public function __construct(OmdbApiGateway $omdbApiGateway) {
        $this->omdbApiGateway = $omdbApiGateway;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('moviePosterUrl', [$this, 'getMoviePosterUrl'])
        ];
    }

    public function getMoviePosterUrl(Movie $movie): string
    {
        $movieFromApi = $this->omdbApiGateway->requestMovieByImdbId($movie->imdbId);
        return array_key_exists('Poster', $movieFromApi) ?
            $movieFromApi['Poster']
            : '';
    }
}
