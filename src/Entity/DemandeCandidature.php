<?php

namespace App\Entity;

use App\Repository\DemandeCandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeCandidatureRepository::class)]
class DemandeCandidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $isValided = null;

    #[ORM\ManyToOne(inversedBy: 'demandeCandidatures')]
    private ?Candidates $userCandidat = null;

    #[ORM\ManyToOne(inversedBy: 'demandeCandidatures')]
    private ?JobOffer $offreEmploi = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function isIsValided(): ?bool
    {
        return $this->isValided;
    }

    public function setIsValided(bool $isValided): static
    {
        $this->isValided = $isValided;

        return $this;
    }

    public function getUserCandidat(): ?Candidates
    {
        return $this->userCandidat;
    }

    public function setUserCandidat(?Candidates $userCandidat): static
    {
        $this->userCandidat = $userCandidat;

        return $this;
    }

    public function getOffreEmploi(): ?JobOffer
    {
        return $this->offreEmploi;
    }

    public function setOffreEmploi(?JobOffer $offreEmploi): static
    {
        $this->offreEmploi = $offreEmploi;

        return $this;
    }
}
