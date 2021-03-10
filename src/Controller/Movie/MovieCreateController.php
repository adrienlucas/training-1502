<?php

namespace App\Controller\Movie;

use App\Entity\Movie;
use App\Form\MovieType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

#[Route('/movie/create', name: 'movie_create')]
class MovieCreateController
{
    private Environment $twig;
    private FormFactoryInterface $formFactory;
    private ObjectManager $entityManager;
    private UrlGeneratorInterface $router;

    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory,
        ManagerRegistry $doctrineRegistry,
        UrlGeneratorInterface $router,
    ) {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->entityManager = $doctrineRegistry->getManager();
        $this->router = $router;
    }

    public function __invoke(
        Request $request,
        Session $session,
    ): Response
    {
        $creationForm = $this->formFactory->create(MovieType::class);

        $creationForm->handleRequest($request);

        if($creationForm->isSubmitted() && $creationForm->isValid()) {
            $movie = $creationForm->getData();

            $this->entityManager->persist($movie);
            $this->entityManager->flush();

            $session->getFlashBag()->add('success', 'The movie has been persisted in database.');

            return new RedirectResponse($this->router->generate('homepage'));
        }

        return new Response($this->twig->render('movie/create.html.twig', [
            'creation_form' => $creationForm->createView(),
        ]));
    }
}
