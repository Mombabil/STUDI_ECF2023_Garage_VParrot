<?php
// En modifiant le fichier service.yaml et avec ce fichier-ci, on redirige l'utilsateur vers la page d'accueil si il saisie une url qui n'est pas valide


namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class Redirect404ToHomeListener
{
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        // If not a HttpNotFoundException ignore
        if (!$event->getThrowable() instanceof NotFoundHttpException) {
            return;
        }
        // crée une redirection vers le controller avec la route app_home en cas d'url invalide
        $response = new RedirectResponse($this->router->generate('app_home'));
        // Set the response to be processed
        $event->setResponse($response);
    }
}
