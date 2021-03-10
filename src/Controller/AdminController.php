<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin", methods={"GET", "POST"})
     */
    public function index(Request $request, AuthorizationCheckerInterface $authorizationChecker): Response
    {
        if(!$authorizationChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if($request->getMethod() === 'POST') {
            if(!$authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
                throw new AccessDeniedException();
            }
            // user creation form
        }

        // user listing
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
