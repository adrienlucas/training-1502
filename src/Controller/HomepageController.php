<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Stopwatch\Stopwatch;

class HomepageController extends AbstractController
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        $this->eventDispatcher->dispatch();
        return $this->render('homepage/index.html.twig');
    }

    #[Route('/_fragment/menu_homepage', name: 'homepage_menu')]
    public function menu(): Response
    {
        return $this->render('homepage/menu.html.twig');
    }
}
