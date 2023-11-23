<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\TrainingSession;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(EntityManagerInterface $em): Response
    {
        $teams = $em->getRepository(Team::class)->findAll();
        $trainingSessions = $em->getRepository(TrainingSession::class)->findAll();

        return $this->render('base.html.twig', [
            'controller_name' => 'MainController',
            'teams' => $teams,
            'trainingSessions' => $trainingSessions,
        ]);
    }
}
