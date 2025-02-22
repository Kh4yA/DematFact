<?php

namespace App\Entity;

use App\Repository\FactureLignesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureLignesRepository::class)]
class FactureLignes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix_unitaire_ht = null;

    #[ORM\Column(length: 255)]
    private ?string $taxe = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $ligne_totale_ht = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $ligne_totale_ttc = null;

    #[ORM\ManyToOne(inversedBy: 'factureLignes')]
    private ?Factures $facture_id = null;

    #[ORM\ManyToOne(inversedBy: 'factureLignes')]
    private ?Organisation $organisation_id = null;

    #[ORM\ManyToOne(inversedBy: 'factureLignes')]
    private ?Prestations $prestation_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrixUnitaireHt(): ?string
    {
        return $this->prix_unitaire_ht;
    }

    public function setPrixUnitaireHt(string $prix_unitaire_ht): static
    {
        $this->prix_unitaire_ht = $prix_unitaire_ht;

        return $this;
    }

    public function getTaxe(): ?string
    {
        return $this->taxe;
    }

    public function setTaxe(string $taxe): static
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getLigneTotaleHt(): ?string
    {
        return $this->ligne_totale_ht;
    }

    public function setLigneTotaleHt(?string $ligne_totale_ht): static
    {
        $this->ligne_totale_ht = $ligne_totale_ht;

        return $this;
    }

    public function getLigneTotaleTtc(): ?string
    {
        return $this->ligne_totale_ttc;
    }

    public function setLigneTotaleTtc(string $ligne_totale_ttc): static
    {
        $this->ligne_totale_ttc = $ligne_totale_ttc;

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

    public function getOrganisationId(): ?organisation
    {
        return $this->organisation_id;
    }

    public function setOrganisationId(?organisation $organisation_id): static
    {
        $this->organisation_id = $organisation_id;

        return $this;
    }

    public function getPrestationId(): ?Prestations
    {
        return $this->prestation_id;
    }

    public function setPrestationId(?Prestations $prestation_id): static
    {
        $this->prestation_id = $prestation_id;

        return $this;
    }
}
