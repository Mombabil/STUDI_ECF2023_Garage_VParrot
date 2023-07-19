<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateEmployeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class CreateEmployeController extends AbstractController
{
    #[Route('/create', name: 'app_create')]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasher, ManagerRegistry $doctrine): Response
    {
        $user = new User($userPasswordHasher);
        $formCreate = $this->createForm(CreateEmployeType::class, $user);
        $formCreate->handleRequest($request);


        // on recupere la liste de tout les employé et l'admin enregistré
        $repository = $doctrine->getRepository(User::class);
        $users = $repository->findAll();

        if ($formCreate->isSubmitted() && $formCreate->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // apres la création, on redirige l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('create_employe/index.html.twig', [
            'users' => $users,
            'formCreate' => $formCreate->createView(),
        ]);
    }
    #[Route('/delete/{id<\d+>}', name: 'app_delete')]
    public function delete(ManagerRegistry $doctrine, User $id)
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_create');
    }
}
