<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $teamName = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $coachs = [];

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: User::class)]
    private Collection $user;

    #[ORM\OneToMany(mappedBy: 'team', targetEntity: TrainingSession::class)]
    private Collection $trainingSessions;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->trainingSessions = new ArrayCollection();
    }
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): static
    {
        $this->teamName = $teamName;

        return $this;
    }


    public function getCoachs(): array
    {
        return $this->coachs;
    }

    public function setCoachs(array $coachs): static
    {
        $this->coachs = $coachs;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setTeam($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTeam() === $this) {
                $user->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrainingSession>
     */
    public function getTrainingSessions(): Collection
    {
        return $this->trainingSessions;
    }

    public function addTrainingSession(TrainingSession $trainingSession): static
    {
        if (!$this->trainingSessions->contains($trainingSession)) {
            $this->trainingSessions->add($trainingSession);
            $trainingSession->setTeam($this);
        }

        return $this;
    }

    public function removeTrainingSession(TrainingSession $trainingSession): static
    {
        if ($this->trainingSessions->removeElement($trainingSession)) {
            // set the owning side to null (unless already changed)
            if ($trainingSession->getTeam() === $this) {
                $trainingSession->setTeam(null);
            }
        }

        return $this;
    }

    
}
