<?php

namespace App\Entity;

use App\Repository\NominaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NominaRepository::class)]
class Nomina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, length: 1)]
    #[Assert\Length(min: 1, max: 1)]
    private ?int $fortnight = null;
    #[ORM\Column(type:'float' ,length: 4)]
    #[Assert\Length(min: 1, max: 4)]
    private ?float $amount = null;

    #[ORM\ManyToOne(inversedBy: 'id_hour')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeHour $typeHour = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $id_employee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_end = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->Date_start;
    }

    public function setDateStart(\DateTimeInterface $Date_start): static
    {
        $this->Date_start = $Date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->Date_end;
    }

    public function setDateEnd(\DateTimeInterface $Date_end): static
    {
        $this->Date_end = $Date_end;

        return $this;
    }


}
