<?php

namespace App\Controller;

use App\Entity\Schedules;
use App\Entity\Services;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // on recupere la liste de tout les services
        $repository = $doctrine->getRepository(Services::class);
        $services = $repository->findAll();

        // on recupere la liste des horaires d'ouverture pour le footer
        $repositorySchedules = $doctrine->getRepository(Schedules::class);
        $schedules = $repositorySchedules->findAll();

        return $this->render('services/index.html.twig', [
            'services' => $services,
            'schedules' => $schedules
        ]);
    }
}
