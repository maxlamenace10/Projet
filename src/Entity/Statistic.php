<?php

namespace App\Entity;

use App\Repository\StatisticRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatisticRepository::class)]
class Statistic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $presence = null;

    #[ORM\Column(nullable: true)]
    private ?int $goals = null;

    #[ORM\Column(nullable: true)]
    private ?int $assists = null;

    #[ORM\Column(nullable: true)]
    private ?int $minutesPlayed = null;

    #[ORM\Column(nullable: true)]
    private ?bool $win = null;

    #[ORM\Column(nullable: true)]
    private ?bool $loss = null;

    #[ORM\Column(nullable: true)]
    private ?bool $draw = null;

    #[ORM\ManyToOne(inversedBy: 'Statistic')]
    private ?Game $game = null;

    #[ORM\ManyToOne(inversedBy: 'statistic')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPresence(): ?bool
    {
        return $this->presence;
    }

    public function setPresence(?bool $presence): static
    {
        $this->presence = $presence;

        return $this;
    }

    public function getGoals(): ?int
    {
        return $this->goals;
    }

    public function setGoals(?int $goals): static
    {
        $this->goals = $goals;

        return $this;
    }

    public function getAssists(): ?int
    {
        return $this->assists;
    }

    public function setAssists(?int $assists): static
    {
        $this->assists = $assists;

        return $this;
    }

    public function getMinutesPlayed(): ?int
    {
        return $this->minutesPlayed;
    }

    public function setMinutesPlayed(?int $minutesPlayed): static
    {
        $this->minutesPlayed = $minutesPlayed;

        return $this;
    }

    public function isWin(): ?bool
    {
        return $this->win;
    }

    public function setWin(?bool $win): static
    {
        $this->win = $win;

        return $this;
    }

    public function isLoss(): ?bool
    {
        return $this->loss;
    }

    public function setLoss(?bool $loss): static
    {
        $this->loss = $loss;

        return $this;
    }

    public function isDraw(): ?bool
    {
        return $this->draw;
    }

    public function setDraw(?bool $draw): static
    {
        $this->draw = $draw;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->user;
    }

    public function setPlayer(?User $user): static
    {
        $this->user = $user
        ;

        return $this;
    }
}
