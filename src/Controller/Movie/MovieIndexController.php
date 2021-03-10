<?php

namespace App\Controller\Movie;

use App\Entity\Movie;
use App\Form\MovieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

#[Route('/movie/{id}', name: 'movie', requirements: ['id' => "\d+"])]
class MovieIndexController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Movie $movie): Response
    {
        return new Response($this->twig->render('movie/index.html.twig', [
            'movie' => $movie,
        ]));
    }
}
