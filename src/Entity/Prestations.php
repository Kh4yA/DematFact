<?php

namespace App\Entity;

use App\Repository\PrestationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationsRepository::class)]
class Prestations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix_ht = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $taxe = null;

    #[ORM\ManyToOne(inversedBy: 'prestations')]
    private ?Organisation $organisation_id = null;

    /**
     * @var Collection<int, FactureLignes>
     */
    #[ORM\OneToMany(targetEntity: FactureLignes::class, mappedBy: 'prestation_id')]
    private Collection $factureLignes;

    public function __construct()
    {
        $this->factureLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

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

    public function getPrixHt(): ?string
    {
        return $this->prix_ht;
    }

    public function setPrixHt(string $prix_ht): static
    {
        $this->prix_ht = $prix_ht;

        return $this;
    }

    public function getTaxe(): ?string
    {
        return $this->taxe;
    }

    public function setTaxe(?string $taxe): static
    {
        $this->taxe = $taxe;

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

    /**
     * @return Collection<int, FactureLignes>
     */
    public function getFactureLignes(): Collection
    {
        return $this->factureLignes;
    }

    public function addFactureLigne(FactureLignes $factureLigne): static
    {
        if (!$this->factureLignes->contains($factureLigne)) {
            $this->factureLignes->add($factureLigne);
            $factureLigne->setPrestationId($this);
        }

        return $this;
    }

    public function removeFactureLigne(FactureLignes $factureLigne): static
    {
        if ($this->factureLignes->removeElement($factureLigne)) {
            // set the owning side to null (unless already changed)
            if ($factureLigne->getPrestationId() === $this) {
                $factureLigne->setPrestationId(null);
            }
        }

        return $this;
    }
}
