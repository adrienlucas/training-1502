<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieTest extends WebTestCase
{
    /**
     * Happy path
     */
    public function testItShowsAMovieFromTheCatalog(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSelectorExists('a[href*="/movie/"]');

        $firstMovieLink = $client->getCrawler()->filter('a[href*="/movie/"]:first-child')->link();
        $client->click($firstMovieLink);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains(
            '.movie-description',
            'matrix'
        );
    }

    /**
     * Sad/Unhappy path
     */
    public function testItGivesAnErrorWhenTheMovieIsNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movie/123');

        $this->assertResponseStatusCodeSame(404);
    }
}
