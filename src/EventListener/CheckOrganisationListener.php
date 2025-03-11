<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;


class CheckOrganisationListener{
    private RouterInterface $router;
    private Security $security;
    private RequestStack $requestStack;

    public function __construct(RouterInterface $router, Security $security, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        // Exclure certaines routes pour éviter une boucle infinie
        $excludedRoutes = ['app_login', 'app_logout', 'app_register', 'app_profil'];

        if (in_array($route, $excludedRoutes)) {
            return;
        }

        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return;
        }

        if (!$user->getOrganisation()) {
            // Récupérer la session et vérifier son type
            $session = $this->requestStack->getSession();

            // Vérifier si la session est bien une instance de Session
            if (!$session instanceof Session) {
                $session = new Session();
                $session->start();
            }

            // Ajouter un message flash
            $session->getFlashBag()->add('warning', 'Vous devez remplir votre profil avant de continuer.');

            // Rediriger vers la page de profil
            $response = new RedirectResponse($this->router->generate('app_profil'));
            $event->setController(fn () => $response);
        }
    }
}
