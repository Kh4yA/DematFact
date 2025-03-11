<?php

namespace App\Entity;

use App\Enum\EnumTypeClient;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('client:read','devis',)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('client:read')]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('client:read')]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Groups('client:read')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 255)]
    #[Groups('client:read')]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('client:read')]
    private ?string $rue = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('client:read')]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('client:read')]
    private ?string $code_postal = null;

    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'clients')]
    private ?Organisation $organisation = null;

    /**
     * @var Collection<int, Facture>
     */
    #[ORM\OneToMany(targetEntity: Facture::class, mappedBy: 'client')]
    private Collection $factures;

    /**
     * @var Collection<int, Devis>
     */
    #[ORM\OneToMany(targetEntity: Devis::class, mappedBy: 'client')]
    private Collection $devis;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups('client:read')]
    private ?string $tel_portable = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('client:read')]
    private ?string $tel_fixe = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('client:read')]
    private ?string $fax = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('client:read')]
    private ?string $raison_sociale= null;

    #[ORM\Column(type: 'bigint', nullable: true)]
    #[Groups('client:read')]
    private ?int $siret = null;

    #[ORM\Column]
    #[Groups('client:read')]
    private ?bool $actif = null;

    #[ORM\Column(type: 'string', length: 20)]
    #[Groups('client:read')]
    private ?string $type = null;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
        $this->devis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

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
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): static
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setClient($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getClient() === $this) {
                $facture->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevi(Devis $devi): static
    {
        if (!$this->devis->contains($devi)) {
            $this->devis->add($devi);
            $devi->setClient($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): static
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getClient() === $this) {
                $devi->setClient(null);
            }
        }

        return $this;
    }

    public function getTelPortable(): ?string
    {
        return $this->tel_portable;
    }

    public function setTelPortable(?string $tel_portable): static
    {
        $this->tel_portable = $tel_portable;

        return $this;
    }

    public function getTelFixe(): ?string
    {
        return $this->tel_fixe;
    }

    public function setTelFixe(?string $tel_fixe): static
    {
        $this->tel_fixe = $tel_fixe;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): static
    {
        $this->fax = $fax;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raison_sociale;
    }

    public function setRaisonSociale(?string $raison_sociale): static
    {
        $this->raison_sociale = $raison_sociale;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    public function getType(): ?EnumTypeClient
    {
        return $this->type ? EnumTypeClient::from($this->type) : null;
    }
    
    public function setType(EnumTypeClient $type): static
    {
        $this->type = $type->value;
        return $this;
    }
}
