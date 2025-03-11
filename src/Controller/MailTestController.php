<?php

namespace App\Controller;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MailTestController extends AbstractController
{
    #[Route('/test-mail', name: 'test_mail')]
    public function sendTestMail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('dematfact@dev-services.ovh')
            ->to('mathieu.daszczynski@yahoo.com')
            ->subject('Test Symfony Mailer OVH')
            ->text('Ceci est un test d’envoi d’email avec OVH.');
        
        $mailer->send($email);

        return new Response('Email envoyé avec succès.');
    }
}