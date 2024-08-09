<?php

namespace App\Entity;

use App\Repository\TypeHourRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeHourRepository::class)]
class TypeHour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $name_hrs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameHrs(): ?string
    {
        return $this->name_hrs;
    }

    public function setNameHrs(string $name_hrs): static
    {
        $this->name_hrs = $name_hrs;

        return $this;
    }
}
