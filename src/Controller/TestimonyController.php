<?php

namespace App\Controller;

use App\Entity\Schedules;
use App\Entity\Testimony;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestimonyController extends AbstractController
{
    #[Route('/testimony', name: 'app_testimony')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // on recupere la liste de tout les temoignages du plus récent au plus ancien
        $repositoryTestimony = $doctrine->getRepository(Testimony::class);
        $testimonyRepo = $repositoryTestimony->findBy([], ['id' => 'desc']);

        // on recupere la liste des horaires d'ouverture pour le footer
        $repositorySchedules = $doctrine->getRepository(Schedules::class);
        $schedules = $repositorySchedules->findAll();

        return $this->render('testimony/index.html.twig', [
            'testimonyRepo' => $testimonyRepo,
            'schedules' => $schedules
        ]);
    }
}
