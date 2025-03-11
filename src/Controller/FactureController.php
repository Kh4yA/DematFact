<?php

namespace App\Controller;

use App\Repository\FactureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FactureController extends AbstractController
{
    /**
     * Prepare la page des facture
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/document/facture', name: 'app_facture')]
    public function factureInterface(Request $request): Response
    {
                /** @var User|null $user */
                $user = $this->getUser();

        $route = $request->getRequestUri(); // Alternative propre à $_SERVER['REQUEST_URI']
        return $this->render('facture/facture.html.twig', [
            'route' => $route,
            'user' => $user,
        ]);
    }
    /**
     * liste toutes lesfactures disponible et les mets au format JSON 
     *
     * @param FactureRepository $repo
     * @return JsonResponse
     */
    #[Route('/api/facture', name: 'api_facture')]
    public function getFacture(FactureRepository $repo, CsrfTokenManagerInterface $csrfTokenManager, Request $request, SerializerInterface $serializer, PaginatorInterface $paginator): JsonResponse
    {
        $query = $repo->createQueryBuilder('c')->getQuery();

        // Utilisation de KnpPaginator pour la pagination
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de la page (par défaut 1)
            2 // Nombre d'éléments par page
        );
        // 🔹 Calcul du nombre total de pages
        $totalPages = ceil($pagination->getTotalItemCount() / $pagination->getItemNumberPerPage());
        // Sérialiser uniquement les champs nécessaires (évite de renvoyer des objets complets)
        $jsonData = $serializer->serialize(
            [
                'items' => $pagination->getItems(), // Les clients paginés
                'current_page' => $pagination->getCurrentPageNumber(),
                'total_pages' => $totalPages
            ],
            'json',
            ['groups' => 'facture:read'] // Groupe de sérialisation pour éviter les problèmes de circularité
        );

        return new JsonResponse($jsonData, 200, [], true);
    }
    #[Route('/api/facture/update', name: 'api_facture_update')]
    public function updateFactureSelection(
        Request $request,
        FactureRepository $repo,
        CsrfTokenManagerInterface $csrfTokenManager
    ): JsonResponse {
        try {
            $data = json_decode($request->getContent(), true);
            // $csrfToken = $request->headers->get('X-CSRF-TOKEN');
            // // Vérifier le token CSRF
            // if (!$csrfToken || !$csrfTokenManager->isTokenValid(new CsrfToken('dematFact_token', $csrfToken))) {
            //     return new JsonResponse(['error' => 'Token CSRF invalide'], JsonResponse::HTTP_FORBIDDEN);
            // }
            // Vérifier la présence de l'ID et de l'état sélectionné
            if (!isset($data['id'], $data['selected'])) {
                return new JsonResponse(['error' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
            }
            // Récupérer la facture
            $facture = $repo->find($data['id']);
            if (!$facture) {
                return new JsonResponse(['error' => 'Facture non trouvée'], JsonResponse::HTTP_NOT_FOUND);
            }

            // Simuler une mise à jour en base (ex: changer un statut)
            $message = $data['selected'] ? 'Facture sélectionnée' : 'Facture désélectionnée';

            return new JsonResponse([
                'status' => 'success',
                'message' => $message,
                'id' => $facture->getId(),
                'selected' => $data['selected']
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
        /**
     * Role : afficher e charger la page pour la creation d'un nouveau facture
     * @return Response
     */
    #[Route('/facture/creer', name: 'app_gestion_facture/create')]
    public function createFacture(): Response
    {
        $route = ($_SERVER['REQUEST_URI']);

        return $this->render('gestion_document/creation_facture.html.twig', [
            'route' => $route,
        ]);
    }
}
