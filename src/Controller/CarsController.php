<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Entity\Schedules;
use App\Form\CarContactType;
use App\Repository\CarsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class CarsController extends AbstractController
{
    #[Route('/voitures', name: 'app_cars', methods: ['GET', 'POST'])]
    public function index(CarsRepository $carsRepo, Request $request, ManagerRegistry $doctrine)
    {
        // on récupere les filtres
        $mileageFilter = $request->get("mileage");
        $priceFilter = $request->get("price");
        $yearFilter = $request->get("year");

        // on recuperes les annonces de voitures de la page en fonction des filtres
        $cars = $carsRepo->getCars($mileageFilter, $priceFilter, $yearFilter);

        // on recupere la liste des horaires d'ouverture pour le footer
        $repositorySchedules = $doctrine->getRepository(Schedules::class);
        $schedules = $repositorySchedules->findAll();


        if ($request->get("ajax")) {
            return new JsonResponse([
                'content' => $this->renderView('cars/_content.html.twig', [
                    'cars' => $cars,
                    'schedules' => $schedules
                ])
            ]);
        }

        return $this->render('cars/index.html.twig', [
            'cars' => $cars,
            'schedules' => $schedules
        ]);
    }

    #[Route('/voitures/{id<\d+>}', name: 'app_car')]
    public function car(Cars $car, Request $request, MailerInterface $mailer, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(CarContactType::class);

        $carContact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on crée le mail
            $email = (new TemplatedEmail())
                ->from($carContact->get('email')->getData())
                ->to('vparrot@gmail.com')
                ->subject("Contact au sujet du véhicule : #" . $car->getId() . " - " . $car->getModele() . ".")
                ->htmlTemplate('emails/car_contact.html.twig')
                ->context([
                    'car' => $car,
                    'mail' => $carContact->get('email')->getData(),
                    'message' => $carContact->get('message')->getData()
                ]);
            // on envoi le mail
            $mailer->send($email);

            // on redirige vers la pages des voitures
            return $this->redirectToRoute('app_cars');
        }

        // on recupere la liste des horaires d'ouverture pour le footer
        $repositorySchedules = $doctrine->getRepository(Schedules::class);
        $schedules = $repositorySchedules->findAll();

        return $this->render('cars/car.html.twig', [
            'car' => $car,
            'carContact' => $form->createView(),
            'schedules' => $schedules
        ]);
    }
}
