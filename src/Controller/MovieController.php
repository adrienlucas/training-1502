<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'movie', requirements: ['id' => "\d+"])]
    public function index(int $id): Response
    {
        $movies = [
            1 => ['title' => 'matrix', 'releaseDate' => new DateTime('1999-02-16'), 'genre' => 'Action'],
            2 => ['title' => '1984', 'releaseDate' => new DateTime('1988-06-22'), 'genre' => 'Political'],
            3 => ['title' => 'Alice in wonderland', 'releaseDate' => new DateTime('1964-01-05'), 'genre' => 'Cartoon'],
        ];

        if(!array_key_exists($id, $movies)) {
            return new Response('Movie not found', 404);
        }

        return $this->render('movie/index.html.twig', [
            'movie' => $movies[$id],
        ]);
    }
}
