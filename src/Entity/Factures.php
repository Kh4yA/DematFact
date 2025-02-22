<?php

namespace App\Entity;

use App\Repository\FacturesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturesRepository::class)]
class Factures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_ht = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $total_tva = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $total_ttc = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $remise = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?clients $client_id = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?user $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?Organisation $organisation_id = null;

    /**
     * @var Collection<int, Paiements>
     */
    #[ORM\OneToMany(targetEntity: Paiements::class, mappedBy: 'facture_id')]
    private Collection $paiements;

    /**
     * @var Collection<int, FactureLignes>
     */
    #[ORM\OneToMany(targetEntity: FactureLignes::class, mappedBy: 'facture_id')]
    private Collection $factureLignes;

    public function __construct()
    {
        $this->paiements = new ArrayCollection();
        $this->factureLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getTotalHt(): ?string
    {
        return $this->total_ht;
    }

    public function setTotalHt(string $total_ht): static
    {
        $this->total_ht = $total_ht;

        return $this;
    }

    public function getTotalTva(): ?string
    {
        return $this->total_tva;
    }

    public function setTotalTva(?string $total_tva): static
    {
        $this->total_tva = $total_tva;

        return $this;
    }

    public function getTotalTtc(): ?string
    {
        return $this->total_ttc;
    }

    public function setTotalTtc(string $total_ttc): static
    {
        $this->total_ttc = $total_ttc;

        return $this;
    }

    public function getRemise(): ?string
    {
        return $this->remise;
    }

    public function setRemise(?string $remise): static
    {
        $this->remise = $remise;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getClientId(): ?clients
    {
        return $this->client_id;
    }

    public function setClientId(?clients $client_id): static
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): static
    {
        $this->user_id = $user_id;

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
     * @return Collection<int, Paiements>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiements $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setFactureId($this);
        }

        return $this;
    }

    public function removePaiement(Paiements $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getFactureId() === $this) {
                $paiement->setFactureId(null);
            }
        }

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
            $factureLigne->setFactureId($this);
        }

        return $this;
    }

    public function removeFactureLigne(FactureLignes $factureLigne): static
    {
        if ($this->factureLignes->removeElement($factureLigne)) {
            // set the owning side to null (unless already changed)
            if ($factureLigne->getFactureId() === $this) {
                $factureLigne->setFactureId(null);
            }
        }

        return $this;
    }
}
