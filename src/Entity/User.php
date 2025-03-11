<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $isEmailAuthEnabled = false;
    
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $twoFactorCode = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $twoFactorExpiresAt = null;

    #[ORM\Column(type: 'boolean', nullable:true )]
private bool $isVerified = false;
    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel_portable = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel_fixe = null;

    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'users', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Organisation $organisation = null;
    
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Devis::class)]
    private Collection $devis;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Facture::class)]
    private Collection $factures;

    public function __construct()
{
    $this->factures = new ArrayCollection();
    $this->devis = new ArrayCollection();
}


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isEmailAuthEnabled(): bool
    {
        return $this->isEmailAuthEnabled;
    }

    public function enableEmailAuth(): void
    {
        $this->isEmailAuthEnabled = true;
    }

    public function disableEmailAuth(): void
    {
        $this->isEmailAuthEnabled = false;
        $this->twoFactorCode = null;
        $this->twoFactorExpiresAt = null;
    }

    public function generateTwoFactorCode(): string
    {
        $this->twoFactorCode = random_int(100000, 999999);
        $this->twoFactorExpiresAt = new \DateTime('+10 minutes');

        return $this->twoFactorCode;
    }

    public function isTwoFactorCodeValid(string $code): bool
    {
        return $this->twoFactorCode === $code && $this->twoFactorExpiresAt > new \DateTime();
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

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

    public function getOrganisation(): ?organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?organisation $organisation): static
    {
        $this->organisation = $organisation;

        return $this;
    }

public function isVerified(): bool
{
    return $this->isVerified;
}

public function setIsVerified(bool $isVerified): self
{
    $this->isVerified = $isVerified;
    return $this;
}
}
