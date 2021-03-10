<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Dumper\MoFileDumper;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getManager()->getRepository(Movie::class);

        return $this->render('homepage/index.html.twig', [
            'movies' => $repository->findAll()
        ]);
    }

    #[Route('/_fragment/menu_homepage', name: 'homepage_menu')]
    public function menu(): Response
    {
        return $this->render('homepage/menu.html.twig');
    }
}
