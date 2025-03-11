<?php

namespace App\Controller;

use App\Form\UserFormType;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserProfilController extends AbstractController
{
    #[Route(path: '/profil', name: 'app_profil')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();
        $route = $request->getRequestUri();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles['ADMIN'];

            if ($user->getOrganisation()) {
                $organisation = $user->getOrganisation();

                // Vérifie si l'organisation est nouvelle (elle n'a pas encore d'ID)
                if ($organisation->getId() === null) {
                    $organisation->setCreatedAt(new \DateTimeImmutable());
                    $em->persist($organisation);
                    $em->flush();
                }
            }

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Profil mis à jour avec succès');
            return $this->redirectToRoute('app_profil');
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Une erreur est survenue. Veuillez vérifier les informations.');
        }

        return $this->render('user_profil/index.html.twig', [
            'route' => $route,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Afficher le profil utilisateur avec possibilité de modification
     * 
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    #[Route(path: '/show/profil', name: 'app_show_profil')]
    public function showProfil(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Aucun utilisateur connecté.');
        }

        $route = $request->getRequestUri();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Profil modifié avec succès.');

            // Redirection après succès pour éviter le rechargement du formulaire avec d'anciennes données
            return $this->redirectToRoute('app_show_profil');
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Une erreur est survenue. Veuillez vérifier les informations.');
        }

        return $this->render('user_profil/show-profil.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'route' => $route,
        ]);
    }
}
