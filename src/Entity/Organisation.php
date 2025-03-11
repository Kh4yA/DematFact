<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrganisationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
class Organisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('devis', 'facture')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups("organisation")]
    private ?string $designation_sociale = null;

    #[ORM\Column(length: 255)]
    #[Groups("organisation")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups("organisation")]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups("organisation")]
    private ?string $rue = null;

    #[ORM\Column(length: 255)]
    #[Groups("organisation")]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    #[Groups("organisation")]
    private ?string $code_postal = null;


    /**
     * @var Collection<int, Client>
     */
    #[ORM\OneToMany(targetEntity: Client::class, mappedBy: 'organisation')]
    private Collection $clients;

    /**
     * @var Collection<int, Facture>
     */
    #[ORM\OneToMany(targetEntity: Facture::class, mappedBy: 'organisation')]
    private Collection $factures;

    /**
     * @var Collection<int, Prestation>
     */
    #[ORM\OneToMany(targetEntity: Prestation::class, mappedBy: 'organisation')]
    private Collection $prestations;

    /**
     * @var Collection<int, Paiement>
     */
    #[ORM\OneToMany(targetEntity: Paiement::class, mappedBy: 'organisation')]
    private Collection $paiements;

    /**
     * @var Collection<int, FactureLigne>
     */
    #[ORM\OneToMany(targetEntity: FactureLigne::class, mappedBy: 'organisation')]
    private Collection $factureLignes;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, Devis>
     */
    #[ORM\OneToMany(mappedBy: 'organisation', targetEntity: Devis::class)]
    private Collection $devis;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private ?int $siret = null;

    /**
     * @var Collection<int, DevisLigne>
     */

    #[ORM\OneToMany(mappedBy: 'organisation', targetEntity: DevisLigne::class)]
    private Collection $devisLignes;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'organisation')]
    private Collection $users;


    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->prestations = new ArrayCollection();
        $this->paiements = new ArrayCollection();
        $this->factureLignes = new ArrayCollection();
        $this->devis = new ArrayCollection();
        $this->devisLignes = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
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

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }


    /**
     * @return Collection<int, Client>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): static
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
            $client->setOrganisation($this);
        }

        return $this;
    }

    public function removeClient(Client $client): static
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getOrganisation() === $this) {
                $client->setOrganisation(null);
            }
        }

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
            $facture->setOrganisation($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): static
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getOrganisation() === $this) {
                $facture->setOrganisation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prestation>
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestation $prestation): static
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations->add($prestation);
            $prestation->setOrganisation($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): static
    {
        if ($this->prestations->removeElement($prestation)) {
            // set the owning side to null (unless already changed)
            if ($prestation->getOrganisation() === $this) {
                $prestation->setOrganisation(null);
            }
        }

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
            $paiement->setOrganisation($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getOrganisation() === $this) {
                $paiement->setOrganisation(null);
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
            $factureLigne->setOrganisation($this);
        }

        return $this;
    }

    public function removeFactureLigne(FactureLigne $factureLigne): static
    {
        if ($this->factureLignes->removeElement($factureLigne)) {
            // set the owning side to null (unless already changed)
            if ($factureLigne->getOrganisation() === $this) {
                $factureLigne->setOrganisation(null);
            }
        }

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

    /**
     * @return Collection<int, Devis>
     */
    public function getDevis(): Collection
    {
        return $this->devis;
    }

    public function addDevis(Devis $devis): static
    {
        if (!$this->devis->contains($devis)) {
            $this->devis->add($devis);
            $devis->setOrganisation($this);
        }

        return $this;
    }

    public function removeDevi(Devis $devi): static
    {
        if ($this->devis->removeElement($devi)) {
            // set the owning side to null (unless already changed)
            if ($devi->getOrganisation() === $this) {
                $devi->setOrganisation(null);
            }
        }

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): static
    {
        $this->siret = $siret;

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
            $devisLigne->setOrganisation($this);
        }

        return $this;
    }

    public function removeDevisLigne(DevisLigne $devisLigne): static
    {
        if ($this->devisLignes->removeElement($devisLigne)) {
            // set the owning side to null (unless already changed)
            if ($devisLigne->getOrganisation() === $this) {
                $devisLigne->setOrganisation(null);
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
            $user->setOrganisation($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOrganisation() === $this) {
                $user->setOrganisation(null);
            }
        }

        return $this;
    }
}
