<?php

namespace App\Entity;

use App\Repository\OperadorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperadorRepository::class)]
class Operador
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $linea = null;

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

    public function getLinea(): ?string
    {
        return $this->linea;
    }

    public function setLinea(string $linea): static
    {
        $this->linea = $linea;

        return $this;
    }
}
