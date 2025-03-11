<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
class Prestation
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

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $prix_ht = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $taxe = null;

    #[ORM\ManyToOne(inversedBy: 'prestations')]
    private ?Organisation $organisation = null;

    /**
     * @var Collection<int, FactureLigne>
     */
    #[ORM\OneToMany(targetEntity: FactureLigne::class, mappedBy: 'prestation')]
    private Collection $factureLignes;

    /**
     * @var Collection<int, DevisLigne>
     */
    #[ORM\OneToMany(mappedBy: 'prestation', targetEntity: DevisLigne::class)]
    private Collection $devisLignes;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $prix_ttc = null;



    public function __construct()
    {
        $this->factureLignes = new ArrayCollection();
        $this->devisLignes = new ArrayCollection();
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

    public function setTaxe(string $taxe): static
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?Organisation $organisation): static
    {
        $this->organisation = $organisation;

        return $this;
    }

    /**
     * @return Collection<int, FactureLigne>
     */
    public function getFactureLignes(): Collection
    {
        return $this->factureLignes;
    }

    public function addFactureLigne(FactureLigne $factureLigne): static
    {
        if (!$this->factureLignes->contains($factureLigne)) {
            $this->factureLignes->add($factureLigne);
            $factureLigne->setPrestation($this);
        }

        return $this;
    }

    public function removeFactureLigne(FactureLigne $factureLigne): static
    {
        if ($this->factureLignes->removeElement($factureLigne)) {
            // set the owning side to null (unless already changed)
            if ($factureLigne->getPrestation() === $this) {
                $factureLigne->setPrestation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DevisLigne>
     */
    public function getDevisLignes(): Collection
    {
        return $this->devisLignes;
    }

    public function addDevisLigne(DevisLigne $devisLigne): static
    {
        if (!$this->devisLignes->contains($devisLigne)) {
            $this->devisLignes->add($devisLigne);
            $devisLigne->setPrestation($this);
        }

        return $this;
    }

    public function removeDevisLigne(DevisLigne $devisLigne): static
    {
        if ($this->devisLignes->removeElement($devisLigne)) {
            // set the owning side to null (unless already changed)
            if ($devisLigne->getPrestation() === $this) {
                $devisLigne->setPrestation(null);
            }
        }

        return $this;
    }

    public function getPrixTtc(): ?string
    {
        return $this->prix_ttc;
    }

    public function setPrixTtc(?string $prix_ttc): static
    {
        $this->prix_ttc = $prix_ttc;

        return $this;
    }


}
