<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateRepository::class)]
class State
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name_state = null;

    #[ORM\ManyToOne(inversedBy: 'Id_State')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $Id_State = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameState(): ?string
    {
        return $this->name_state;
    }

    public function setNameState(string $name_state): static
    {
        $this->name_state = $name_state;

        return $this;
    }

    public function getIdState(): ?Employee
    {
        return $this->Id_State;
    }

    public function setIdState(?Employee $Id_State): static
    {
        $this->Id_State = $Id_State;

        return $this;
    }
}
