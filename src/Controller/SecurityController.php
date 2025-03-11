<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $route = $request->getRequestUri();
        $user = $this->getUser();
        if ($user) {
            return $this->redirectToRoute('app_dashbord');
            }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'route' => $route,
            'user' => $user,
        ]);
    }


    #[Route('/2fa/send', name: 'app_2fa_send')]
    public function send2FACode(MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User || !$user->isEmailAuthEnabled()) {
            return $this->redirectToRoute('app_login');
        }

        $code = $user->generateTwoFactorCode();
        $entityManager->persist($user);
        $entityManager->flush();

        $email = (new Email())
            ->from('dematfact@dev-services.ovh')
            ->to($user->getEmail())
            ->subject('Votre code de validation 2FA')
            ->text("Votre code est : $code");

        $mailer->send($email);

        return $this->redirectToRoute('app_2fa_verify');
    }
    
    #[Route('/2fa/verify', name: 'app_2fa_verify')]
    public function verify2FA(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User || !$user->isEmailAuthEnabled()) {
            return $this->redirectToRoute('app_login');
        }

        if ($request->isMethod('POST')) {
            $code = $request->request->get('code');

            if ($user->isTwoFactorCodeValid($code)) {
                $this->addFlash('success', 'Authentification réussie.');
                return $this->redirectToRoute('app_dashbord');
            }

            $this->addFlash('error', 'Code incorrect ou expiré.');
        }

        return $this->render('security/verify_2fa.html.twig');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}