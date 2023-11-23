<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\User;
use App\Form\TeamType;
use Doctrine\Persistence\ManagerRegistry; // Modified line
use Doctrine\ORM\EntityManagerInterface;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{

    private $doctrine;
    private $entityManager;


    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $entityManager;
    }

    #[Route('/team', name: 'team_index')]
    public function index(): Response
    {
        $allTeams = $this->doctrine->getRepository(Team::class)->findAll();

        $currentUser = $this->getUser();

        $teams = array_filter($allTeams, function($team) use ($currentUser) {
            $teamPlayers = $team->getUser();
            return in_array($currentUser, $teamPlayers->toArray()) || in_array('ROLE_COACH', $currentUser->getRoles());
        });

        return $this->render('team/index.html.twig', [
            'teams' => $teams,
        ]);
    }





    #[Route('/team/new', name: 'team_new')]
    public function new(Request $request): Response
    {
        if (!$this->isGranted('ROLE_COACH')) {
            throw $this->createAccessDeniedException('Seuls les coachs peuvent créer une équipe.');
        }

        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/team/{id}', name: 'team_show')]
    public function show($id): Response
    {
        $id = (int) $id;
        $team = $this->doctrine->getRepository(Team::class)->find($id);
        $users = $this->doctrine->getRepository(User::class)->findBy(['team' => null]);

            $teamPlayers = $team->getUser();
        $firstName = count($users) > 0 ? $users[0]->getFirstName() : null;

        return $this->render('team/show.html.twig', [
            'team' => $team,
            'teamPlayers' => $teamPlayers,
            'users' => $users,
        ]);
    }

    #[Route('/team/{id}/add-player/{userId}', name: 'team_add_player')]
    public function addPlayerToTeam(int $id, int $userId)
{
    if (!$this->isGranted('ROLE_COACH')) {
        throw $this->createAccessDeniedException('Seuls les coachs peuvent ajouter des joueurs à une équipe.');
    }
    $team = $this->doctrine->getRepository(Team::class)->find($id);
    $user = $this->doctrine->getRepository(User::class)->find($userId);

    $userId = $user->getId();
    $players = $team->getUser();
    if ($players !== null) {
        $playersArray = $players->toArray();
        if (!in_array($user, $playersArray)) {
            $team->addUser($user);
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($team);
            $entityManager->flush();
        } else {
            $this->addFlash('error', 'Ce joueur est déjà dans cette équipe.');
        }
    }

    return $this->redirectToRoute('team_show', ['id' => $id]);
}

    #[Route('/team/{teamId}/remove-player/{userId}', name: 'team_remove_player')]
    public function removePlayer($teamId, $userId)
    {
        if (!$this->isGranted('ROLE_COACH')) {
            throw $this->createAccessDeniedException('Seuls les coachs peuvent supprimer des joueurs à une équipe.');
        }
        $team = $this->doctrine->getRepository(Team::class)->find($teamId);
        $user = $this->doctrine->getRepository(User::class)->find($userId);
        $players = $team->getUser();

        if ($players->contains($user)) {
            $team->removeUser($user);
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_show', ['id' => $team->getId()]);
    }

    #[Route('/team/{id}/edit', name: 'team_edit')]

    public function edit(Request $request, $id): Response
    {
        if (!$this->isGranted('ROLE_COACH')) {
            throw $this->createAccessDeniedException('Seuls les coachs peuvent modifier une équipe.');
        }

        $team = $this->doctrine->getRepository(Team::class)->find($id); 
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $team = $form->getData();
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('team_index');
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/team/{teamId}/delete', name: 'team_delete', methods: ['post'])]
    public function delete(Request $request, $teamId): Response
    {
        if (!$this->isGranted('ROLE_COACH')) {
            throw $this->createAccessDeniedException('Seuls les coachs peuvent supprimer une équipe.');
        }
        $team = $this->doctrine->getRepository(Team::class)->find($teamId);


        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->request->get('_token'))) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->remove($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index');
    }

    #[Route('/team/{id}/add-coach', name: 'team_add_coach')]
    public function addCoach(Team $team, User $coach): Response
    {
        if (!$this->isGranted('ROLE_COACH')) {
            throw $this->createAccessDeniedException('Seuls les coachs peuvent ajouter des coachs à une équipe.');
        }

        $team = $this->doctrine->getRepository(Team::class)->find($team);
        $coach = $this->doctrine->getRepository(User::class)->find($coach);
        $coachs = $team->getCoachs();
        if (!$coachs->contains($coach)) {
            $coachs->add($coach);
            $team->setCoachs($coachs);
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index', ['id' => $team->getId()]);
    }

    #[Route('/team/{id}/remove-coach', name: 'team_remove_coach')]
    public function removeCoach(Team $team, User $coach): Response
    {
        if (!$this->isGranted('ROLE_COACH')) {
            throw $this->createAccessDeniedException('Seuls les coachs peuvent supprimer des coachs à une équipe.');
        }
        $team = $this->doctrine->getRepository(Team::class)->find($team);
        $coach = $this->doctrine->getRepository(User::class)->find($coach);
        $coachs = $team->getCoachs();
        if ($coachs->contains($coach)) {
            $coachs->removeElement($coach);
            $team->setCoachs($coachs);
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($team);
            $entityManager->flush();
        }

        return $this->redirectToRoute('team_index', ['id' => $team->getId()]);
    }
}
