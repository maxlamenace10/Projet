<?php

namespace App\Entity;

use App\Repository\TrainingStatisticRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingStatisticRepository::class)]
class TrainingStatistic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $expectedDelay = null;

    #[ORM\Column(nullable: true)]
    private ?bool $expectedAbsence = null;

    #[ORM\Column(nullable: true)]
    private ?bool $expectedPresence = null;

    #[ORM\Column(nullable: true)]
    private ?bool $actualDelay = null;

    #[ORM\Column(nullable: true)]
    private ?bool $actualPresence = null;

    #[ORM\Column(nullable: true)]
    private ?bool $actualAbsence = null;


    #[ORM\ManyToOne(inversedBy: 'trainingStatistics')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'trainingStatistics')]
    private ?TrainingSession $trainingSession = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpectedDelay(): ?int
    {
        return $this->expectedDelay;
    }

    public function setExpectedDelay(?int $expectedDelay): static
    {
        $this->expectedDelay = $expectedDelay;

        return $this;
    }

    public function getExpectedPresence(): ?int
    {
        return $this->expectedPresence;
    }

    public function setExpectedPresence(?int $expectedPresence): static
    {
        $this->expectedPresence = $expectedPresence;

        return $this;
    }

    public function getExpectedAbsence(): ?int
    {
        return $this->expectedAbsence;
    }

    public function setExpectedAbsence(?int $expectedAbsence): static
    {
        $this->expectedAbsence = $expectedAbsence;

        return $this;
    }

    public function getActualDelay(): ?bool
    {
        return $this->actualDelay;
    }

    public function setActualDelay(?bool $actualDelay): static
    {
        $this->actualDelay = $actualDelay;

        return $this;
    }

    public function getActualPresence(): ?bool
    {
        return $this->actualPresence;
    }

    public function setActualPresence(?bool $actualPresence): static
    {
        $this->actualPresence = $actualPresence;

        return $this;
    }

    public function getActualAbsence(): ?bool
    {
        return $this->actualAbsence;
    }

    public function setActualAbsence(?bool $actualAbsence): static
    {
        $this->actualAbsence = $actualAbsence;

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

    public function getTrainingSession(): ?TrainingSession
    {
        return $this->trainingSession;
    }

    public function setTrainingSession(?TrainingSession $trainingSession): static
    {
        $this->trainingSession = $trainingSession;

        return $this;
    }
}
