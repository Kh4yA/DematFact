<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Enum\EnumTypeClient;
use App\Form\CreateClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GestionClientController extends AbstractController
{
    #[Route('Gestion-client/liste-client', name: 'app_gestion_client')]
    public function index(Request $request): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        $route = $request->getRequestUri(); // Alternative propre à $_SERVER['REQUEST_URI']
        return $this->render('gestion_client/index.html.twig', [
            'route' => $route,
            'user' => $user,
        ]);
    }

    /**
     * Undocumented function
     *
     * @param ClientRepository $client
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/client', name: 'app_api_client')]
    public function showClient(ClientRepository $client, SerializerInterface $serializer, PaginatorInterface $paginator, Request $request): JsonResponse
    {

        $query = $client->createQueryBuilder('c')->getQuery();
        // Utilisation de KnpPaginator pour la pagination
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            7
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
            ['groups' => 'client:read']
        );

        return new JsonResponse($jsonData, 200, [], true);
    }


    #[Route('/api/client/update', name: 'api_client_update')]
    public function updatelientSelection(
        Request $request,
        ClientRepository $repo,
        CsrfTokenManagerInterface $csrfTokenManager
    ): JsonResponse {
        try {
            $data = json_decode($request->getContent(), true);
            // $csrfToken = $request->headers->get('X-CSRF-TOKEN');
            // // Vérifier le token CSRF
            // if (!$csrfToken || !$csrfTokenManager->isTokenValid(new CsrfToken('dematFact_token', $csrfToken))) {
            //     return new JsonResponse(['error' => 'Token CSRF invalide',], JsonResponse::HTTP_FORBIDDEN);
            // }
            // Vérifier la présence de l'ID et de l'état sélectionné
            if (!isset($data['id'], $data['selected'])) {
                return new JsonResponse(['error' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
            }
            // Récupérer la client
            $client = $repo->find($data['id']);
            if (!$client) {
                return new JsonResponse(['error' => 'client non trouvée'], JsonResponse::HTTP_NOT_FOUND);
            }

            // Simuler une mise à jour en base (ex: changer un statut)
            $message = $data['selected'] ? 'client sélectionnée' : 'client désélectionnée';

            return new JsonResponse([
                'status' => 'success',
                'message' => $message,
                'id' => $client->getId(),
                'selected' => $data['selected']
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Route pour la creation d'un nouveau client
     * Recoit les informations les verifient et les traitent
     * @param Request $request
     * 
     */
    #[Route('/client/creer', name: 'app_gestion_client/create')]
    public function createClient(ClientRepository $repo, EntityManagerInterface $em, Request $request): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        $route = $request->getRequestUri();
        $form = $this->createForm(CreateClientFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data->setOrganisation($user->getOrganisation());
            $data->setCreatedAt(new DateTimeImmutable('now'));
            $data->setActif(true);
            // Vérifier si la case "Client professionnel" est cochée
            $isPro = $form->get('isPro')->getData() ?? false;
            // Appliquer l'ENUM correspondant
            if ($isPro) {
                $data->setType(EnumTypeClient::PARTICULIER);
            } else {
                $data->setType(EnumTypeClient::ENTREPRISE);
            }
            $client = $repo->findOneBy(['nom' => $data->getNom(), 'prenom' => $data->getPrenom()]);
            if ($client) {
                $this->addFlash('error', 'Un client à ce nom existe déjà !');
                return $this->redirectToRoute('app_gestion_client/create');
            }
            // Créer un nouveau client
            $em->persist($data);
            $em->flush();
            $this->addFlash('success', 'Client créé avec succès !');
            return $this->redirectToRoute('app_gestion_client/create');
        } else if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Formulaire non valide !');
            return $this->redirectToRoute('app_gestion_client/create');
        }


        return $this->render('gestion_client/creation.html.twig', [
            'route' => $route,
            'createclientform' => $form,
            'user' => $user,
        ]);
    }
}
