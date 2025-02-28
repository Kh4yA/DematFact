<?php

namespace App\Controller;

use App\Form\LoginFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(Request $resquet): Response
    {
        $route = $resquet->getRequestUri();
        $form = $this->createForm(LoginFormType::class);

        return $this->render('login/index.html.twig', [
            'loginForm' => $form,
            'route' => $route,
        ]);
    }
}
