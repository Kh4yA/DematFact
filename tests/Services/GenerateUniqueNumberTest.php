<?php

namespace App\Tests\Services;

use App\Services\GenerateUniqueNumber;
use App\Entity\Devis;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class GenerateUniqueNumberTest extends TestCase
{
    public function testFirstDevisNumber(): void
    {
        // 1️⃣ Simuler un EntityManager retournant NULL (aucun devis en base)
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
    
        $entityManager->method('getRepository')->willReturn($repository);
        $repository->method('findOneBy')->willReturn(null); // Aucun devis existant
    
        // ✅ Instancier GenerateUniqueNumber avec le mock
        $service = new GenerateUniqueNumber($entityManager);
        $generatedNumber = $service->constructNumber();
    
        $expected = 'D-' . date('Y') . '-' . date('m') . '-001';
        $this->assertEquals($expected, $generatedNumber, "Le premier devis doit commencer à 001");
    }

    public function testIncrementDevisNumber(): void
    {
        // 2️⃣ Simuler un EntityManager retournant un dernier devis existant
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $repository = $this->createMock(EntityRepository::class);
        
        $lastDevis = $this->createMock(Devis::class);
        $lastDevis->method('getNumero')->willReturn('D-2025-04-007'); // Dernier numéro connu

        $entityManager->method('getRepository')->willReturn($repository);
        $repository->method('findOneBy')->willReturn($lastDevis);

        $service = new GenerateUniqueNumber($entityManager);
        $generatedNumber = $service->constructNumber();

        $expected = 'D-'.date('Y').'-'.date('m').'-008'; // Doit s'incrémenter de 1
        $this->assertEquals($expected, $generatedNumber, "Le numéro doit s'incrémenter correctement");
    }
}