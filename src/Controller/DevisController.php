<?php

namespace App\Controller;

use App\Repository\DevisRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DevisController extends AbstractController
{
    /**
     * Prepare la page des devis
     *
     * @param Request $request
     * @return Response
     */
    #[Route('/document/devis', name: 'app_devis')]
    public function devisInterface(Request $request): Response
    {
        $route = $request->getRequestUri(); // Alternative propre à $_SERVER['REQUEST_URI']
        return $this->render('devis/devis.html.twig', [
            'route' => $route,
        ]);
    }
    /**
     * liste toutes les devis disponible et les mets au format JSON 
     *
     * @param DevisRepository $repo
     * @return JsonResponse
     */
    #[Route('/api/devis', name: 'api_devis', methods: ['GET'])]
    public function getDevis(DevisRepository $repo, CsrfTokenManagerInterface $csrfTokenManager, Request $request,SerializerInterface $serializer, PaginatorInterface $paginator): JsonResponse
    {
        $query = $repo->createQueryBuilder('c')->getQuery();

        // Utilisation de KnpPaginator pour la pagination
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de la page (par défaut 1)
            10 // Nombre d'éléments par page
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
            ['groups' => 'devis:read'] // Groupe de sérialisation pour éviter les problèmes de circularité
        );

        return new JsonResponse($jsonData, 200, [], true);
    }
    #[Route('/api/devis/update', name: 'api_devis_update')]
    public function updateDevisSelection(
        Request $request,
        DevisRepository $repo,
        CsrfTokenManagerInterface $csrfTokenManager
    ): JsonResponse {
        try {
            $data = json_decode($request->getContent(), true);
            $csrfToken = $request->headers->get('X-CSRF-TOKEN');
            // Vérifier le token CSRF
            if (!$csrfToken || !$csrfTokenManager->isTokenValid(new CsrfToken('dematFact_token', $csrfToken))) {
                return new JsonResponse(['error' => 'Token CSRF invalide',], JsonResponse::HTTP_FORBIDDEN);
            }
            // Vérifier la présence de l'ID et de l'état sélectionné
            if (!isset($data['id'], $data['selected'])) {
                return new JsonResponse(['error' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
            }
            // Récupérer la devis
            $devis = $repo->find($data['id']);
            if (!$devis) {
                return new JsonResponse(['error' => 'devis non trouvée'], JsonResponse::HTTP_NOT_FOUND);
            }

            // Simuler une mise à jour en base (ex: changer un statut)
            $message = $data['selected'] ? 'devis sélectionnée' : 'devis désélectionnée';

            return new JsonResponse([
                'status' => 'success',
                'message' => $message,
                'id' => $devis->getId(),
                'selected' => $data['selected']
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
        /**
     * Role : afficher e charger la page pour la creation d'un nouveau devis
     * @return Response
     */
    #[Route('/devis/creer', name: 'app_gestion_devis/create')]
    public function createDevis(): Response
    {
        $route = ($_SERVER['REQUEST_URI']);

        return $this->render('gestion_document/creation_devis.html.twig', [
            'route' => $route,
        ]);
    }

}
