<?php

namespace App\Controller;

use App\Entity\Schedules;
use App\Form\ContactType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(ContactType::class);

        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on crée le mail
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('vparrot@gmail.com')
                ->subject("Demande d'informations")
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData()
                ]);
            // on envoi le mail
            $mailer->send($email);

            // on redirige vers la pages des voitures
            return $this->redirectToRoute('app_contact');
        }

        // on recupere la liste des horaires d'ouverture pour le footer
        $repositorySchedules = $doctrine->getRepository(Schedules::class);
        $schedules = $repositorySchedules->findAll();

        return $this->render('contact/index.html.twig', [
            'contact' => $form->createView(),
            'schedules' => $schedules
        ]);
    }
}
