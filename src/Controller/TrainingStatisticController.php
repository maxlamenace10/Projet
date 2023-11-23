<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Entity\TrainingSession;
use App\Entity\TrainingStatistic;
use App\Form\TrainingStatisticType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrainingStatisticController extends AbstractController
{

    private $doctrine;
    private $entityManager;
    private $security;

    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager, Security $security)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }
    
    #[Route('/training/statistic', name: 'app_training_statistic')]
    public function index(): Response
    {
        return $this->render('training_statistic/index.html.twig', [
            'controller_name' => 'TrainingStatisticController',
        ]);
    }

    
    #[Route('/training/statistic/new/{sessionTrainingId}/{teamId}', name: 'app_training_statistic_new')]
    public function new(Request $request, $sessionTrainingId, $teamId): Response
    {
        $team = $this->doctrine->getRepository(Team::class)->find($teamId);
        $teamUsers = $this->doctrine->getRepository(User::class)->findBy(['team' => $team]);
    
        $trainingSession = $this->doctrine->getRepository(TrainingSession::class)->find($sessionTrainingId);
    
        $forms = [];
        foreach ($teamUsers as $user) {
            $trainingStatistic = $this->doctrine->getRepository(TrainingStatistic::class)->findOneBy([
                'user' => $user,
                'trainingSession' => $trainingSession,
            ]);
    
            if (!$trainingStatistic) {
                $trainingStatistic = new TrainingStatistic();
                $trainingStatistic->setUser($user);
                $trainingStatistic->setTrainingSession($trainingSession);
            }
    
            $form = $this->createForm(TrainingStatisticType::class, $trainingStatistic);
            $forms[] = $form;
        }
    
        foreach ($forms as $form) {
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->doctrine->getManager();
                $entityManager->persist($form->getData());
                $entityManager->flush();
            }
        }
    
        if ($request->isMethod('POST')) {
            return $this->redirectToRoute('app_training_session');
        }
    
        return $this->render('training_statistic/new.html.twig', [
            'forms' => array_map(function ($form) {
                return $form->createView();
            }, $forms),
        ]);
    }
}
