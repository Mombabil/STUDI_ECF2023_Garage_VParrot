<?php

namespace App\Controller;

use App\Entity\Schedules;
use App\Entity\Testimony;
use App\Form\TestimonyType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        // on recupere la liste des horaires d'ouverture
        $repositorySchedules = $doctrine->getRepository(Schedules::class);
        $schedules = $repositorySchedules->findAll();

        // on recupere la liste des 3 derniers temoignages (seulement ceux déja validé par l'admin)
        $repositoryTestimony = $doctrine->getRepository(Testimony::class);
        $testimonyRepo = $repositoryTestimony->findBy(['isValidated' => 1], ['id' => 'DESC'], 3);

        // on crée le formulaire pour les témoignages
        $testimony = new Testimony();
        $formTestimony = $this->createForm(TestimonyType::class, $testimony);
        $formTestimony->handleRequest($request);

        if ($formTestimony->isSubmitted() && $formTestimony->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($testimony);
            $entityManager->flush();

            // apres la création, on redirige l'utilisateur vers le panel d'administration
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'schedules' => $schedules,
            'testimonies' => $testimonyRepo,
            "formTestimony" => $formTestimony->createView()
        ]);
    }
}
