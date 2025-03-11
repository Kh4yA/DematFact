<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FactureRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('facture:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('facture:read')]
    private ?string $numero = null;

    #[ORM\Column]
    #[Groups('facture:read')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255)]
    #[Groups('facture:read')]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups('facture:read', nullable: true)]
    private ?string $total_ht = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups('facture:read', nullable: true)]
    private ?string $total_tva = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups('facture:read')]
    private ?string $total_ttc = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('facture:read', nullable: true)]
    private ?string $remise_pourcent = null;

    #[ORM\Column(length:255)]
    #[Groups('facture:read', nullable: true)]
    private ?string $remise = null;

    #[ORM\Column(nullable: true)]
    #[Groups('facture')]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups('facture')]
    private ?\DateTimeInterface $date_emission = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;
    
    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?Organisation $organisation = null;

    /**
     * @var Collection<int, Paiement>
     */
    #[ORM\OneToMany(targetEntity: Paiement::class, mappedBy: 'facture')]
    private Collection $paiements;

    /**
     * @var Collection<int, FactureLigne>
     */
    #[ORM\OneToMany(targetEntity: FactureLigne::class, mappedBy: 'facture')]
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

    public function setTotalTva(string $total_tva): static
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

    public function getRemisePourcent(): ?string
    {
        return $this->remise_pourcent;
    }

    public function setRemisePourcent(?string $remise_pourcent): static
    {
        $this->remise_pourcent = $remise_pourcent;

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

    public function getUpadatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpadatedAt(?\DateTimeImmutable $upadated_at): static
    {
        $this->updated_at = $upadated_at;

        return $this;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->date_emission;
    }

    public function setDateEmission(?\DateTimeInterface $date_emission): static
    {
        $this->date_emission = $date_emission;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setFacture($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getFacture() === $this) {
                $paiement->setFacture(null);
            }
        }

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
            $factureLigne->setFacture($this);
        }

        return $this;
    }

    public function removeFactureLigne(FactureLigne $factureLigne): static
    {
        if ($this->factureLignes->removeElement($factureLigne)) {
            // set the owning side to null (unless already changed)
            if ($factureLigne->getFacture() === $this) {
                $factureLigne->setFacture(null);
            }
        }

        return $this;
    }

}
