<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GestionClientController extends AbstractController
{
    /**
     * Role : 
     *
     * @return Response
     */
    #[Route('/gestion-client/liste-client', name: 'app_gestion_client')]
    public function index(ClientRepository $client, Request $request): Response
    {
        $route = $request->getRequestUri(); // Alternative propre à $_SERVER['REQUEST_URI']
        $clients = $client->findBy(
            [], // Pas de critère (récupère tous les clients)
            ['id' => 'DESC'], // Trie par ID descendant
            10, // Limite à 10 résultats
            0 // Offset à 0 (récupère depuis le début)
        );
    
        return $this->render('gestion_client/index.html.twig', [
            'route' => $route,
            'clients' => $clients,
        ]);
    }    /**
     * Role : afficher e charger la page pour la creation d'un nouveau client
     * @return Response
     */
    #[Route('/gestion-client/creer-client', name: 'app_gestion_client/create')]
    public function createClient(): Response
    {
        $route = ($_SERVER['REQUEST_URI']);

        return $this->render('gestion_client/creation.html.twig', [
            'route' => $route,
        ]);
    }
}
