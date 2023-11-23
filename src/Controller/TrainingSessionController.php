<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\TrainingSession;
use App\Entity\TrainingStatistic;
use App\Form\TrainingSessionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrainingSessionController extends AbstractController
{
    private $doctrine;
    private $entityManager;

    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $entityManager;
    }

    #[Route('/training/session', name: 'app_training_session')]
    public function index(): Response
    {
        $currentUser = $this->getUser();

        $allTrainingSessions = $this->doctrine->getRepository(TrainingSession::class)->findAll();

        $training_sessions = array_filter($allTrainingSessions, function($session) use ($currentUser) {
            $team = $session->getTeam();
            $teamPlayers = $team->getUser();
            return in_array($currentUser, $teamPlayers->toArray()) || in_array('ROLE_COACH', $currentUser->getRoles());
        });

        if (empty($training_sessions)) {
            return $this->render('training_session/index.html.twig', [
                'error_message' => 'Aucune session de d\'entrainement n\'a été trouvée.',
            ]);
        }

        $date = $training_sessions[0]->getDate();
        $teamId = $training_sessions[0]->getTeam()->getId();
        $teamName = $training_sessions[0]->getTeam()->getTeamName();

        return $this->render('training_session/index.html.twig', [
            'controller_name' => 'TrainingSessionController',
            'training_sessions' => $training_sessions,
            'date' => $date,
            'teamId' => $teamId,
            'teamName' => $teamName,
        ]);
    }

    #[Route('/training/session/new', name: 'app_training_session_new')]
    public function new(Request $request): Response
    {
        if (!$this->isGranted('ROLE_COACH')) {
            throw $this->createAccessDeniedException('Seuls les coachs peuvent ajouter des joueurs à une équipe.');
        }

        $training_session = new TrainingSession();
        $form = $this->createForm(TrainingSessionType::class, $training_session);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();

            $existingSession = $entityManager
                ->getRepository(TrainingSession::class)
                ->findOneBy(['date' => $training_session->getDate(), 'team' => $training_session->getTeam()]);

            $existingSessionNumber = $entityManager
                ->getRepository(TrainingSession::class)
                ->findOneBy(['sessionNumber' => $training_session->getSessionNumber(), 'team' => $training_session->getTeam()]);

            if ($existingSession) {
                $this->addFlash('error', 'Une session d\'entraînement existe déjà pour cette équipe à cette date.');
            } elseif ($existingSessionNumber) {
                $this->addFlash('error', 'Une session d\'entraînement avec ce numéro existe déjà pour cette équipe.');
            } else {
                $entityManager->persist($training_session);
                $entityManager->flush();

                return $this->redirectToRoute('app_training_session');
            }
        }
        return $this->render('training_session/new.html.twig', [
            'training_session' => $training_session,
            'form' => $form->createView(),
        ]);
    }



    #[Route('/training/session/{id}', name: 'app_training_session_show')]
    public function training_session_show($id): Response
    {

        $training_session = $this->doctrine->getRepository(TrainingSession::class)->find($id);
        
       $training_statistics = $this->doctrine->getRepository(TrainingStatistic::class)->findBy(['trainingSession' => $training_session]);

       if (!empty($training_statistics)) {
        $actualDelay = $training_statistics[0]->getActualDelay();
        $actualAbsence = $training_statistics[0]->getActualAbsence();
        $actualPresence = $training_statistics[0]->getActualPresence();
    }

        return $this->render('training_session/show.html.twig', [
            'controller_name' => 'TrainingSessionController',
            'training_session' => $training_session,
            'training_statistics' => $training_statistics,
        ]);
    }

    #[Route('/training/session/{id}/edit', name: 'app_training_session_edit')]
    public function edit(Request $request,$id): Response
    {
        $trainingSession = $this->doctrine->getRepository(TrainingSession::class)->find($id);
        $form = $this->createForm(TrainingSessionType::class, $trainingSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->flush();

            return $this->redirectToRoute('app_training_session');
        }

        return $this->render('training_session/edit.html.twig', [
            'training_session' => $trainingSession,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/training/session/{id}/delete', name: 'app_training_session_delete')]
    public function delete(Request $request, $id): Response
    { $trainingSession = $this->doctrine->getRepository(TrainingSession::class)->find($id);

        $trainingStatistics = $this->doctrine->getRepository(TrainingStatistic::class)->findBy(['trainingSession' => $trainingSession]);
    
        $entityManager = $this->doctrine->getManager();

        foreach ($trainingStatistics as $trainingStatistic) {
            $entityManager->remove($trainingStatistic);
        }
    
        $entityManager->remove($trainingSession);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_training_session');
    }

}
