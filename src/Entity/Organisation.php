<?php

namespace App\Entity;

use App\Repository\OrganisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
class Organisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation_sociale = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $code_postale = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?int $abonnement_id = null;

    /**
     * @var Collection<int, Clients>
     */
    #[ORM\OneToMany(targetEntity: Clients::class, mappedBy: 'organisation_id')]
    private Collection $clients;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'organisation_id')]
    private Collection $users;

    /**
     * @var Collection<int, Factures>
     */
    #[ORM\OneToMany(targetEntity: Factures::class, mappedBy: 'organisation_id')]
    private Collection $factures;

    /**
     * @var Collection<int, Paiements>
     */
    #[ORM\OneToMany(targetEntity: Paiements::class, mappedBy: 'organisation_id')]
    private Collection $paiements;

    /**
     * @var Collection<int, Prestations>
     */
    #[ORM\OneToMany(targetEntity: Prestations::class, mappedBy: 'organisation_id')]
    private Collection $prestations;

    /**
     * @var Collection<int, FactureLignes>
     */
    #[ORM\OneToMany(targetEntity: FactureLignes::class, mappedBy: 'organisation_id')]
    private Collection $factureLignes;

    /**
     * @var Collection<int, Users>
     */

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->prestations = new ArrayCollection();
        $this->factureLignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignationSociale(): ?string
    {
        return $this->designation_sociale;
    }

    public function setDesignationSociale(string $designation_sociale): static
    {
        $this->designation_sociale = $designation_sociale;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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

    public function getCodePostale(): ?string
    {
        return $this->code_postale;
    }

    public function setCodePostale(string $code_postale): static
    {
        $this->code_postale = $code_postale;

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

    public function getAbonnementId(): ?int
    {
        return $this->abonnement_id;
    }

    public function setAbonnementId(?int $abonnement_id): static
    {
        $this->abonnement_id = $abonnement_id;

        return $this;
    }

    /**
     * @return Collection<int, Clients>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Clients $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->setOrganisationId($this);
        }

        return $this;
    }

    public function removeClient(Clients $client): static
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getOrganisationId() === $this) {
                $client->setOrganisationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setOrganisationId($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOrganisationId() === $this) {
                $user->setOrganisationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Factures>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Factures $facture): static
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setOrganisationId($this);
        }

        return $this;
    }

    public function removeFacture(Factures $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getOrganisationId() === $this) {
                $facture->setOrganisationId(null);
            }
        }

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
            $paiement->setOrganisationId($this);
        }

        return $this;
    }

    public function removePaiement(Paiements $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getOrganisationId() === $this) {
                $paiement->setOrganisationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prestations>
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestations $prestation): static
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations->add($prestation);
            $prestation->setOrganisationId($this);
        }

        return $this;
    }

    public function removePrestation(Prestations $prestation): static
    {
        if ($this->prestations->removeElement($prestation)) {
            // set the owning side to null (unless already changed)
            if ($prestation->getOrganisationId() === $this) {
                $prestation->setOrganisationId(null);
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
            $factureLigne->setOrganisationId($this);
        }

        return $this;
    }

    public function removeFactureLigne(FactureLignes $factureLigne): static
    {
        if ($this->factureLignes->removeElement($factureLigne)) {
            // set the owning side to null (unless already changed)
            if ($factureLigne->getOrganisationId() === $this) {
                $factureLigne->setOrganisationId(null);
            }
        }

        return $this;
    }
}
