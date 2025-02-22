<?php

namespace App\Entity;

use App\Repository\PaiementsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementsRepository::class)]
class Paiements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_paiement = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $moyen_paiement = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?Factures $facture_id = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    private ?Organisation $organisation_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->date_paiement;
    }

    public function setDatePaiement(\DateTimeInterface $date_paiement): static
    {
        $this->date_paiement = $date_paiement;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMoyenPaiement(): ?string
    {
        return $this->moyen_paiement;
    }

    public function setMoyenPaiement(string $moyen_paiement): static
    {
        $this->moyen_paiement = $moyen_paiement;

        return $this;
    }

    public function getFactureId(): ?Factures
    {
        return $this->facture_id;
    }

    public function setFactureId(?Factures $facture_id): static
    {
        $this->facture_id = $facture_id;

        return $this;
    }

    public function getOrganisationId(): ?Organisation
    {
        return $this->organisation_id;
    }

    public function setOrganisationId(?Organisation $organisation_id): static
    {
        $this->organisation_id = $organisation_id;

        return $this;
    }
}
