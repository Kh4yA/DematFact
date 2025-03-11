<?php

namespace App\Entity;

use App\Repository\DevisLigneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisLigneRepository::class)]
class DevisLigne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Devis::class, inversedBy: 'devisLignes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Devis $devis = null;

    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'devisLignes')]
    private ?Organisation $organisation = null;

    #[ORM\ManyToOne(targetEntity: Prestation::class, inversedBy: 'devisLignes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prestation $prestation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $prix_unitaire_ht = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $taxe = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $ligne_totale_ht = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $ligne_totale_ttc = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $prix_unitaire_ttc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevis(): ?devis
    {
        return $this->devis;
    }

    public function setDevis(?devis $devis): static
    {
        $this->devis = $devis;

        return $this;
    }

    public function getOrganisation(): ?organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?organisation $organisation): static
    {
        $this->organisation = $organisation;

        return $this;
    }

    public function getPrestation(): ?prestation
    {
        return $this->prestation;
    }

    public function setPrestation(?prestation $prestation): static
    {
        $this->prestation = $prestation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
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

    public function setLigneTotaleHt(string $ligne_totale_ht): static
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

    public function getPrixUnitaireTtc(): ?string
    {
        return $this->prix_unitaire_ttc;
    }

    public function setPrixUnitaireTtc(?string $prix_unitaire_ttc): static
    {
        $this->prix_unitaire_ttc = $prix_unitaire_ttc;

        return $this;
    }
}
