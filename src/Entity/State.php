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

    public function __toString(): string
    {
        return (string) $this->getNameState();
    }


}
