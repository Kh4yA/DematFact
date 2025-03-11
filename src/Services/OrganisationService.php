<?php

namespace App\Services;

use App\Entity\Organisation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class OrganisationService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createOrganisation(string $nom, User $user): Organisation
    {
        $organisation = new Organisation();
        $organisation->setDesignationSociale($nom);
        
        // Ajout de l'organisation à l'utilisateur
        $user->setOrganisation($organisation);
        $user->setRoles(['ROLE_ADMIN']); // L'utilisateur devient admin

        $this->entityManager->persist($organisation);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $organisation;
    }
}