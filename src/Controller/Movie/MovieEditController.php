<?php

namespace App\Controller\Movie;

use App\Entity\Movie;
use App\Form\MovieType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

#[Route('/movie/edit/{id}', name: 'movie_edit')]
class MovieEditController
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

    /**
     * @IsGranted("MOVIE_EDIT", subject="movie")
     */
    public function __invoke(
        Movie $movie,
        Request $request,
        Session $session,
    ): Response
    {
        $editionForm = $this->formFactory->create(MovieType::class, $movie);

        $editionForm->handleRequest($request);

        if($editionForm->isSubmitted() && $editionForm->isValid()) {

            $this->entityManager->flush();
            $session->getFlashBag()->add('success', 'The movie has been updated in database.');

            return new RedirectResponse($this->router->generate('homepage'));
        }

        return new Response($this->twig->render('movie/edit.html.twig', [
            'edition_form' => $editionForm->createView(),
        ]));
    }
}
