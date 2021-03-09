<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        ////////////////////// PHP 7
        ///
        ///
//        $genre = new Genre();
//        $genre->setName('Action');
//        $manager->persist($genre);
//
//        $movie = new Movie();
//        $movie->setTitle('matrix');
//        $movie->setReleaseDate(new DateTime('1999-02-16'));
//        $movie->setDescription('Lorem ipsum');
//        $movie->setGenre($genre);
//
//        $manager->persist($movie);

        //////////////// PHP 8
        ///
        ///
        $genre = new Genre();
        $genre->setName('Action');
        $manager->persist($genre);

        $movie = new Movie(title: 'matrix', releaseDate: new DateTime('1999-02-16'), description: 'Lorem Ipsum', genre: $genre);
        $manager->persist($movie);

        $genre = new Genre();
        $genre->setName('Political');
        $manager->persist($genre);

        $movie = new Movie(title: '1984', releaseDate: new DateTime('1988-06-22'), description: 'Lorem Ipsum', genre: $genre);
        $manager->persist($movie);

        $genre = new Genre();
        $genre->setName('Cartoon');
        $manager->persist($genre);

        $movie = new Movie(title: 'Alice in wonderland', releaseDate: new DateTime('1964-01-05'), description: 'Lorem Ipsum', genre: $genre);
        $manager->persist($movie);

        $manager->flush();
    }
}
