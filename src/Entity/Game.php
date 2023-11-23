<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Opponent')]
    private ?Team $firstTeam = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: Statistic::class)]
    private Collection $statistic;

    #[ORM\ManyToOne(inversedBy: 'statistic')]
    private ?User $user = null;

    public function __construct()
    {
        $this->statistic = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstTeam(): ?Team
    {
        return $this->firstTeam;
    }

    public function setFirstTeam(?Team $firstTeam): static
    {
        $this->firstTeam = $firstTeam;

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
     * @return Collection<int, Statistic>
     */
    public function getStatistic(): Collection
    {
        return $this->statistic;
    }

    public function addStatistic(Statistic $statistic): static
    {
        if (!$this->statistic->contains($statistic)) {
            $this->statistic->add($statistic);
            $statistic->setGame($this);
        }

        return $this;
    }

    public function removeStatistic(Statistic $statistic): static
    {
        if ($this->statistic->removeElement($statistic)) {
            // set the owning side to null (unless already changed)
            if ($statistic->getGame() === $this) {
                $statistic->setGame(null);
            }
        }

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->user;
    }

    public function setPlayer(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
