<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Form\DevisType;
use App\Entity\DevisLigne;
use App\Enum\EnumTypeDevis;
use App\Form\DevisLigneFormType;
use App\Repository\DevisRepository;
use App\Repository\ClientRepository;
use App\Repository\PrestationRepository;
use App\Services\PdfGeneratorService;
use App\Services\GenerateUniqueNumber;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        /** @var User|null $user */
        $user = $this->getUser();

        $route = $request->getRequestUri(); // Alternative propre à $_SERVER['REQUEST_URI']
        return $this->render('devis/devis.html.twig', [
            'route' => $route,
            'user' => $user,
        ]);
    }


    /**
     * liste toutes les devis disponible et les mets au format JSON 
     *
     * @param DevisRepository $repo
     * @return JsonResponse
     */
    #[Route('/api/devis', name: 'api_devis', methods: ['GET'])]
    public function getDevis(DevisRepository $repo, CsrfTokenManagerInterface $csrfTokenManager, Request $request, SerializerInterface $serializer, PaginatorInterface $paginator): JsonResponse
    {

        $query = $repo->createQueryBuilder('c')->getQuery();

        // Utilisation de KnpPaginator pour la pagination
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de la page (par défaut 1)
            7 // Nombre d'éléments par page
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
    public function updatelientSelection(
        Request $request,
        devisRepository $repo,
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
    public function create(
        Request $request, 
        EntityManagerInterface $entityManager, 
        GenerateUniqueNumber $uniqueNumber, 
        ClientRepository $clientRepo,
        PrestationRepository $prestationRepo
    ): Response {
        /** @var User|null $user */
        $user = $this->getUser();
        $clients = $clientRepo->findAll();
        $route = $request->getRequestUri();
        $prestations = $prestationRepo->findAll();

        // Création de l'objet Devis et passage au formulaire
        $devis = new Devis();
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Configuration du devis
            $devis->setNumero($uniqueNumber->generatorNumber());
            $devis->setCreatedAt(new \DateTimeImmutable());
            $devis->setUpdateAt(new \DateTimeImmutable());
            $devis->setStatut(EnumTypeDevis::BROUILLON);
            $devis->setUser($user);
            $devis->setOrganisation($user->getOrganisation());
            $clientSelectedId = $request->request->get('client');
            $clientSelected = $clientRepo->find($clientSelectedId);
            $devis->setClient($clientSelected);
    
            // Persiste le devis pour obtenir un ID si nécessaire
            $entityManager->persist($devis);
            $montantTotal = 0;
            // Association de chaque ligne au devis
            foreach ($devis->getDevisLignes() as $ligne) {
                $ligne->setDevis($devis);
                $prestationId = $request->request->get('prestation_id');
                $prestation = $prestationRepo->find($prestationId);
                $ligne->setPrestation($prestation);
                $entityManager->persist($ligne);
                $montantTotal += $ligne->getPrixUnitaireTtc() * $ligne->getQuantite();
            }
            $devis->setTotalTtc($montantTotal);
            $entityManager->flush();
            $this->addFlash('success', 'Devis créé avec succès !');
            return $this->redirectToRoute('app_devis');
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            // Cas où le formulaire est soumis mais contient des erreurs
            $this->addFlash('error', 'Problème lors de la soumission du devis.');
        }
    
        return $this->render('devis/create_devis.html.twig', [
            'form' => $form->createView(),
            'route' => $route,
            'clients' => $clients,
            'prestations'=> $prestations,
        ]);
    }    /**
     * Creation d'un pdf
     */
    #[Route('/devis/creer/output-pdf', name: 'app_output_pdf')]
    public function createDevisPdf(PdfGeneratorService $pdfGeneratorService, Request $request): Response
    {
        // Données dynamiques pour le devis
        $data = [
            "entreprise" => [
                "nom" => "Entreprise XYZ",
                "adresse" => "123 Rue des Exemples, 75000 Paris",
                "tel" => "01 23 45 67 89"
            ],
            "client" => [
                "nom" => "Jean Dupont",
                "adresse" => "456 Avenue des Clients, 69000 Lyon"
            ],
            "devis" => [
                "numero" => "DEV-" . date("YmdHis"),
                "date" => date("d/m/Y")
            ],
            "services" => [
                ["description" => "Création de site web", "quantite" => 1, "prix_unitaire" => 1200],
                ["description" => "Maintenance mensuelle", "quantite" => 6, "prix_unitaire" => 100]
            ]
        ];

        // Vérifier que la liste des services n'est pas vide
        $total_ht = 0;
        if (!empty($data["services"])) {
            $total_ht = array_sum(array_map(fn($s) => $s["quantite"] * $s["prix_unitaire"], $data["services"]));
        }
        $tva = $total_ht * 0.2;
        $total_ttc = $total_ht + $tva;

        // Ajouter les totaux aux données Twig
        $data["totaux"] = [
            "total_ht" => number_format($total_ht, 2, ',', ' '),
            "tva" => number_format($tva, 2, ',', ' '),
            "total_ttc" => number_format($total_ttc, 2, ',', ' ')
        ];

        // Générer le HTML à partir de Twig
        $html = $this->renderView('pdf/devis_pdf.html.twig', ['data' => $data]);

        // Générer le PDF avec le service
        $content = $pdfGeneratorService->generatePdf($html, $data['entreprise']['nom'], $data['entreprise']['adresse'], '<h1>Conditions générales de vente</h1>');

        // Nom du fichier
        $filename = "devis_{$data['devis']['numero']}.pdf";

        // Retourner le PDF en réponse
        return new Response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
}
