<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'movie', requirements: ['id' => "\d+"])]
    public function index(Movie $movie): Response
    {
        return $this->render('movie/index.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/movie/create', name: 'movie_create')]
    public function create(Request $request): Response
    {
        $creationForm = $this->createForm(MovieType::class);

        $creationForm->handleRequest($request);

        if($creationForm->isSubmitted() && $creationForm->isValid()) {
            $movie = $creationForm->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($movie);
            $entityManager->flush();

            $this->addFlash('success', 'The movie has been persisted in database.');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('movie/create.html.twig', [
            'creation_form' => $creationForm->createView(),
        ]);
    }
}
