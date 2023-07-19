<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Schedules;
use App\Entity\Services;
use App\Entity\Testimony;
use App\Form\CarsType;
use App\Form\CarsUpdateType;
use App\Form\SchedulesType;
use App\Form\ServicesType;
use App\Form\ServicesUpdateType;
use App\Form\TestimonyType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/admin')]
class AdminController extends AbstractController
{

    // ESPACE ADMIN TABLEAU DE BORD
    #[Route('/', name: 'app_admin')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // on recupere la liste de tous les services
        $repositoryServices = $doctrine->getRepository(Services::class);
        $services = $repositoryServices->findAll();

        // on recupere la liste de tous les véhicules
        $repositoryCars = $doctrine->getRepository(Cars::class);
        $cars = $repositoryCars->findAll();

        // on recupere la liste de tous les témoignages et on calcule la moyenne des notes
        $repositoryTestimony = $doctrine->getRepository(Testimony::class);
        $testimony = $repositoryTestimony->findAll();
        for ($i = 0; $i < count($testimony); $i++) {
            $testimonyNote[] = $testimony[$i]->getNote();
        }
        $sommeNotes = array_sum($testimonyNote);
        $moyenneNotes = $sommeNotes / count($testimonyNote);


        // on recupere la liste des horaires d'ouverture et l'admin enregistré
        $repositorySchedules = $doctrine->getRepository(Schedules::class);
        $schedules = $repositorySchedules->find(1);

        // modification des horaires via le formulaire
        $formEditSchedules = $this->createForm(SchedulesType::class, $schedules);
        $formEditSchedules->handleRequest($request);

        if ($formEditSchedules->isSubmitted() && $formEditSchedules->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($schedules);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/index.html.twig', [
            'servicesList' => $services,
            'carsList' => $cars,
            'testimonyList' => $testimony,
            'testimonyNote' => $moyenneNotes,
            'schedules' => $schedules,
            'formSchedules' => $formEditSchedules->createView(),
        ]);
    }

    // ESPACE ADMIN SERVICES
    #[Route('/services', name: 'app_admin_services')]
    public function adminService(Request $request, ManagerRegistry $doctrine): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $service = new Services();
        $formServices = $this->createForm(ServicesType::class, $service);
        $formServices->handleRequest($request);

        // on recupere la liste de tout les services
        $repository = $doctrine->getRepository(Services::class);
        $services = $repository->findBy([], ['id' => 'desc']);

        if ($formServices->isSubmitted() && $formServices->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            // apres la création, on redirige l'utilisateur vers le panel d'administration
            return $this->redirectToRoute('app_admin_services');
        }

        return $this->render('admin/services.html.twig', [
            'services' => $services,
            "formServices" => $formServices->createView()
        ]);
    }
    #[Route('/services/validation/{id<\d+>}', name: 'app_admin_services_validation')]
    public function adminServiceValidation(ManagerRegistry $doctrine, Services $service): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // on passe la validation sur true et on push la modification dans la bdd
        $service->setIsValidated(true);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($service);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_services');
    }
    #[Route('/services/edit/{id<\d+>}', name: 'app_admin_services_edit')]
    public function adminServicesUpdate(Request $request, Services $service, ManagerRegistry $doctrine): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // on recupere la liste de tout les services
        $repository = $doctrine->getRepository(Services::class);
        $services = $repository->findAll();

        $formEditService = $this->createForm(ServicesUpdateType::class, $service);
        $formEditService->handleRequest($request);

        if ($formEditService->isSubmitted() && $formEditService->isValid()) {

            // apres modification, la validation est à nouveau nécessaire par l'administrateur
            $service->setIsValidated(false);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_services');
        }

        return $this->render('admin/services-update.html.twig', [
            'services' => $services,
            'serviceUpdateForm' => $formEditService->createView(),
            // protection du formulaire
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'post_item',
        ]);
    }
    #[Route('/services/delete/{id<\d+>}', name: 'app_admin_services_delete')]
    public function adminServiceDelete(ManagerRegistry $doctrine, Services $id)
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Services::class);
        $service = $repository->find($id);
        $entityManager->remove($service);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_services');
    }

    // ESPACE ADMIN VOITURES
    #[Route('/voitures', name: 'app_admin_cars')]
    public function adminCars(Request $request, ManagerRegistry $doctrine): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $car = new Cars();
        $formCars = $this->createForm(CarsType::class, $car);
        $formCars->handleRequest($request);

        // on recupere la liste de toutes les voitures du plus récent au plus ancien
        $repository = $doctrine->getRepository(Cars::class);
        $cars = $repository->findBy([], ['id' => 'desc']);

        if ($formCars->isSubmitted() && $formCars->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            // apres la création, on redirige l'utilisateur vers le panel d'administration
            return $this->redirectToRoute('app_admin_cars');
        }

        return $this->render('admin/cars.html.twig', [
            'cars' => $cars,
            "formCars" => $formCars->createView()
        ]);
    }
    #[Route('/voitures/validation/{id<\d+>}', name: 'app_admin_cars_validation')]
    public function adminCarsValidation(ManagerRegistry $doctrine, Cars $car): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // on passe la validation sur true et on push la modification dans la bdd
        $car->setIsValidated(true);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($car);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_cars');
    }
    #[Route('/voitures/edit/{id<\d+>}', name: 'app_admin_cars_edit')]
    public function adminCarsUpdate(Request $request, Cars $car, ManagerRegistry $doctrine): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // on recupere la liste de tout les services
        $repository = $doctrine->getRepository(Cars::class);
        $cars = $repository->findAll();

        $formEditCar = $this->createForm(CarsUpdateType::class, $car);
        $formEditCar->handleRequest($request);

        if ($formEditCar->isSubmitted() && $formEditCar->isValid()) {

            // apres modification, la validation est à nouveau nécessaire par l'administrateur
            $car->setIsValidated(false);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_cars');
        }

        return $this->render('admin/cars-update.html.twig', [
            'cars' => $cars,
            'carUpdateForm' => $formEditCar->createView(),
            // protection du formulaire
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'post_item',
        ]);
    }
    #[Route('/voitures/delete/{id<\d+>}', name: 'app_admin_cars_delete')]
    public function adminCarDelete(ManagerRegistry $doctrine, Cars $id)
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Cars::class);
        $car = $repository->find($id);
        $entityManager->remove($car);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_cars');
    }

    // ESPACE ADMIN TEMOIGNAGES
    #[Route('/commentaires', name: 'app_admin_testimony')]
    public function adminTestimony(Request $request, ManagerRegistry $doctrine): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $testimony = new Testimony();
        $formTestimony = $this->createForm(TestimonyType::class, $testimony);
        $formTestimony->handleRequest($request);

        // on recupere la liste de tout les témoignages
        $repository = $doctrine->getRepository(Testimony::class);
        $testimonyList = $repository->findAll();

        if ($formTestimony->isSubmitted() && $formTestimony->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($testimony);
            $entityManager->flush();

            // apres la création, on redirige l'utilisateur vers le panel d'administration
            return $this->redirectToRoute('app_admin_testimony');
        }

        return $this->render('admin/testimony.html.twig', [
            'testimonyList' => $testimonyList,
            "formTestimony" => $formTestimony->createView()
        ]);
    }
    #[Route('/commentaires/validation/{id<\d+>}', name: 'app_admin_testimony_validation')]
    public function adminTestimonyValidation(ManagerRegistry $doctrine, Testimony $testimony): Response
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // on passe la validation sur true et on push la modification dans la bdd
        $testimony->setIsValidated(true);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($testimony);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_testimony');
    }
    #[Route('/commentaires/delete/{id<\d+>}', name: 'app_admin_testimony_delete')]
    public function adminTestimonyDelete(ManagerRegistry $doctrine, Testimony $id)
    {
        // si l'utilisateur n'est pas connecté, redirige vers login
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Testimony::class);
        $testimony = $repository->find($id);
        $entityManager->remove($testimony);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_testimony');
    }
}
