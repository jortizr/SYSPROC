<?php

namespace App\Entity;

use App\Repository\NominaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NominaRepository::class)]
class Nomina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $fortnight = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\ManyToOne(inversedBy: 'id_hour')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeHour $typeHour = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $id_employee = null;

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

    public function getFortnight(): ?int
    {
        return $this->fortnight;
    }

    public function setFortnight(int $fortnight): static
    {
        $this->fortnight = $fortnight;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getTypeHour(): ?TypeHour
    {
        return $this->typeHour;
    }

    public function setTypeHour(?TypeHour $typeHour): static
    {
        $this->typeHour = $typeHour;

        return $this;
    }

    public function getIdEmployee(): ?employee
    {
        return $this->id_employee;
    }

    public function setIdEmployee(?employee $id_employee): static
    {
        $this->id_employee = $id_employee;

        return $this;
    }

}
