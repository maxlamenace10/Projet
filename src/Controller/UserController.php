<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private $doctrine;
    private $entityManager;


    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $entityManager;

    }
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_show')]
    public function user_show($id): Response
    {
       $user = $this->doctrine->getRepository(User::class)->find($id);
        $lastname = $user->getLastname();
        $firstname = $user->getFirstname();
        $height = $user->getHeight();
        $weight = $user->getWeight();
        $position = $user->getPosition();
        $profilePicture = $user->getProfilePicture();

        $trainingStatistic = $user->getTrainingStatistics();

        return $this->render('user/show.html.twig', [

            'user' => $user,
        ]);
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit')]
    public function edit(Request $request, $id, EntityManagerInterface $em): Response
    {
        $user = $em->getRepository(User::class)->find($id);
    
        if (!$user) {
            throw $this->createNotFoundException('No user found for id '.$id);
        }
    
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
    
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()]);
        }
    
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
