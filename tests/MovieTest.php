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
        $client->request('GET', '/movie/1');

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
