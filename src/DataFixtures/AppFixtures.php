<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

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
        $user = new User();
        $user->setUsername('adrien');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$G2eey3HcC0C3EWzKEnahrA$LxOMS4aTwYm+Opczo0Cwp1F6S5AlD3iX+pmX2y0NlSs');
        $user->setRoles(['ROLE_ADMIN', 'ROLE_ALLOWED_TO_SWITCH']);
        $manager->persist($user);

        $firstUser = new User();
        $firstUser->setUsername('lucas');
        $firstUser->setPassword('$argon2id$v=19$m=65536,t=4,p=1$lovgqGRR9sjGyvDWmZ5yIQ$POoZC0JlAfagrMm1laB5I3affL7jrx5MSyNu7RHoI9A');
        $firstUser->setRoles(['ROLE_USER']);
        $manager->persist($firstUser);

        $secondUser = new User();
        $secondUser->setUsername('toto');
        $secondUser->setPassword('$argon2id$v=19$m=65536,t=4,p=1$lovgqGRR9sjGyvDWmZ5yIQ$POoZC0JlAfagrMm1laB5I3affL7jrx5MSyNu7RHoI9A');
        $secondUser->setRoles(['ROLE_USER']);
        $manager->persist($secondUser);

        $genre = new Genre();
        $genre->setName('Action');
        $manager->persist($genre);

        $movie = new Movie(
            title: 'matrix',
            releaseDate: new DateTime('1999-02-16'),
            description: 'Lorem Ipsum',
            genre: $genre,
            imdbId: 'tt0133093',
            creator: $firstUser
        );
        $manager->persist($movie);

        $genre = new Genre();
        $genre->setName('Political');
        $manager->persist($genre);

        $movie = new Movie(
            title: '1984',
            releaseDate: new DateTime('1988-06-22'),
            description: 'Lorem Ipsum',
            genre: $genre,
            creator: $firstUser,
        );
        $manager->persist($movie);

        $genre = new Genre();
        $genre->setName('Cartoon');
        $manager->persist($genre);

        $movie = new Movie(
            title: 'Alice in wonderland',
            releaseDate: new DateTime('1964-01-05'),
            description: 'Lorem Ipsum',
            genre: $genre,
            creator: $secondUser,
        );
        $manager->persist($movie);

        $manager->flush();
    }
}
