<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'movie', requirements: ['id' => "\d+"])]
    public function index(int $id, Request $request): Response
    {
        $movies = [
            1 => 'matrix',
            2 => '1984',
            3 => 'Alice in wonderland',
        ];

        if(!array_key_exists($id, $movies)) {
            return new Response('Movie not found', 404);
        }

        return $this->render('movie/index.html.twig', [
            'movie_name' => $movies[$id],
            'should_highlight' => $request->query->get('highlight', false)
        ]);
    }
}
