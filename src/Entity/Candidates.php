<?php

namespace App\Entity;

use App\Repository\CandidatesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: CandidatesRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Candidates implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = ['ROLE_CANDIDATE'];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $cvFilename = null;

    #[ORM\OneToMany(targetEntity: DemandeCandidature::class, mappedBy: 'userCandidat')]
    private Collection $demandeCandidatures;

    public function __construct()
    {
        $this->demandeCandidatures = new ArrayCollection();
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
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
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
    public function getCvFilename(): ?string
    {
        return $this->cvFilename;
    }

    public function setCvFilename(?string $cvFilename): static
    {
        $this->cvFilename = $cvFilename;

        return $this;
    }

    /**
     * @return Collection<int, DemandeCandidature>
     */
    public function getDemandeCandidatures(): Collection
    {
        return $this->demandeCandidatures;
    }

    public function addDemandeCandidature(DemandeCandidature $demandeCandidature): static
    {
        if (!$this->demandeCandidatures->contains($demandeCandidature)) {
            $this->demandeCandidatures->add($demandeCandidature);
            $demandeCandidature->setUserCandidat($this);
        }

        return $this;
    }

    public function removeDemandeCandidature(DemandeCandidature $demandeCandidature): static
    {
        if ($this->demandeCandidatures->removeElement($demandeCandidature)) {
            // set the owning side to null (unless already changed)
            if ($demandeCandidature->getUserCandidat() === $this) {
                $demandeCandidature->setUserCandidat(null);
            }
        }

        return $this;
    }
    
}
