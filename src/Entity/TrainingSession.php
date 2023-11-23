<?php

namespace App\Entity;

use App\Entity\Team;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\TrainingSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TrainingSessionRepository::class)]
class TrainingSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $sessionNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'trainingSession', targetEntity: TrainingStatistic::class)]
    private Collection $trainingStatistics;

    #[ORM\ManyToOne(inversedBy: 'trainingSessions')]
    private ?team $team = null;

    public function __construct()
    {
        $this->trainingStatistics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionNumber(): ?int
    {
        return $this->sessionNumber;
    }

    public function setSessionNumber(int $sessionNumber): static
    {
        $this->sessionNumber = $sessionNumber;

        return $this;
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

    /**
     * @return Collection<int, TrainingStatistic>
     */
    public function getTrainingStatistics(): Collection
    {
        return $this->trainingStatistics;
    }

    public function addTrainingStatistic(TrainingStatistic $trainingStatistic): static
    {
        if (!$this->trainingStatistics->contains($trainingStatistic)) {
            $this->trainingStatistics->add($trainingStatistic);
            $trainingStatistic->setTrainingSession($this);
        }

        return $this;
    }

    public function removeTrainingStatistic(TrainingStatistic $trainingStatistic): static
    {
        if ($this->trainingStatistics->removeElement($trainingStatistic)) {
            // set the owning side to null (unless already changed)
            if ($trainingStatistic->getTrainingSession() === $this) {
                $trainingStatistic->setTrainingSession(null);
            }
        }

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }
}
