<?php 

namespace App\Services;

use App\Entity\Devis;
use Doctrine\ORM\EntityManagerInterface;

class GenerateUniqueNumber
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Génère un numéro de devis unique au format DYYYYMMXXX
     * 
     * @return string
     */
    public function generatorNumber(): string
    {
        $year = date('Y');
        $month = date('m');

        // Récupérer le dernier numéro existant en base
        $lastDevis = $this->entityManager->getRepository(Devis::class)
            ->findOneBy([], ['id' => 'DESC']);

        if ($lastDevis) {
            // Extraire le dernier numéro de devis et l'incrémenter
            preg_match('/D\d{4}\d{2}(\d+)/', $lastDevis->getNumero(), $matches);
            $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        } else {
            $lastNumber = 0;
        }

        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        return sprintf('D%s%s%s', $year, $month, $newNumber);
    }
}