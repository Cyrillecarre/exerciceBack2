<?php

namespace App\Entity;

use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobOfferRepository::class)]
class JobOffer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $schedules = null;

    #[ORM\Column]
    private ?int $salary = null;

    #[ORM\Column (type: 'boolean')]
    private ?bool $isPublished;

    #[ORM\OneToMany(targetEntity: DemandeCandidature::class, mappedBy: 'offreEmploi')]
    private Collection $demandeCandidatures;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getSchedules(): ?int
    {
        return $this->schedules;
    }

    public function setSchedules(int $schedules): static
    {
        $this->schedules = $schedules;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): static
    {
        $this->salary = $salary;

        return $this;
    }
    public function __construct()
    {
    $this->isPublished = true;
    $this->demandeCandidatures = new ArrayCollection();
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }
    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

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
            $demandeCandidature->setOffreEmploi($this);
        }

        return $this;
    }

    public function removeDemandeCandidature(DemandeCandidature $demandeCandidature): static
    {
        if ($this->demandeCandidatures->removeElement($demandeCandidature)) {
            // set the owning side to null (unless already changed)
            if ($demandeCandidature->getOffreEmploi() === $this) {
                $demandeCandidature->setOffreEmploi(null);
            }
        }

        return $this;
    }
}
