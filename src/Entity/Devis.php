<?php

namespace App\Entity;

use App\Enum\EnumTypeDevis;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DevisRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("devis:read")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("devis:read")]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups("devis:read")]
    private ?\DateTimeInterface $date_emission = null;

    #[ORM\Column(length: 20)]
    #[Groups("devis:read")]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, options: ["default" => 0])]
    #[Groups("devis:read")]
    private string $total_ht = "0.00";

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2,options: ["default" => 0])]
    #[Groups("devis:read")]
    private ?string $total_ttc = "0.00";

    #[ORM\ManyToOne(inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups("devis:read")]
    private ?Client $client = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'devis')]
    #[Groups("devis:read")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("devis:read")]
    private ?Organisation $organisation = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2,options: ["default" => 0])]
    #[Groups("devis:read")]
    private ?string $total_tva = '0.00';

    #[ORM\Column(length: 255)]
    #[Groups("devis:read")]
    private ?string $remise = '0.00';

    #[ORM\Column]
    #[Groups("devis:read")]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Groups("devis:read")]
    private ?\DateTimeImmutable $update_at = null;

    /**
     * @var Collection<int, DevisLigne>
     */
    #[ORM\OneToMany(mappedBy: 'devis', targetEntity: DevisLigne::class, cascade: ['persist', 'remove'])]
    private Collection $devisLignes;

    public function __construct()
    {
        $this->devisLignes = new ArrayCollection();
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

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->date_emission;
    }

    public function setDateEmission(\DateTimeInterface $date_emission): static
    {
        $this->date_emission = $date_emission;

        return $this;
    }

    public function getStatut(): ?EnumTypeDevis
    {
        return $this->statut ? EnumTypeDevis::from($this->statut) : null;
    }

    public function setStatut(EnumTypeDevis $statut): static
    {
        $this->statut = $statut->value;
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

    public function getTotalTtc(): ?string
    {
        return $this->total_ttc;
    }

    public function setTotalTtc(string $total_ttc): static
    {
        $this->total_ttc = $total_ttc;

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

    public function getTotalTva(): ?string
    {
        return $this->total_tva;
    }

    public function setTotalTva(string $total_tva): static
    {
        $this->total_tva = $total_tva;

        return $this;
    }

    public function getRemise(): ?string
    {
        return $this->remise;
    }

    public function setRemise(string $remise): static
    {
        $this->remise = $remise;

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

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): static
    {
        $this->update_at = $update_at;

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
            $devisLigne->setDevis($this);
        }

        return $this;
    }

    public function removeDevisLigne(DevisLigne $devisLigne): static
    {
        if ($this->devisLignes->removeElement($devisLigne)) {
            // set the owning side to null (unless already changed)
            if ($devisLigne->getDevis() === $this) {
                $devisLigne->setDevis(null);
            }
        }

        return $this;
    }
}
