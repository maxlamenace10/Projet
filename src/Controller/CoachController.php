<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{
    #[Route('/admin', name: 'app_coach')]

    public function index(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Vous n\'avez pas le rôle nécessaire pour accéder à cette page.');
        }
        
        return $this->render('coach/index.html.twig', [
            'controller_name' => 'CoachController',
        ]);
    }
}
