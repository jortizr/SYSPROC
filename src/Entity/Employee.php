<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 90)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $cc = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?state $ID_State = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?JobTitle $Cod_JobTitle = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?schedule $Id_schedule = null;

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

    public function getCc(): ?int
    {
        return $this->cc;
    }

    public function setCc(int $cc): static
    {
        $this->cc = $cc;

        return $this;
    }

    public function getIDState(): ?state
    {
        return $this->ID_State;
    }

    public function setIDState(?state $ID_State): static
    {
        $this->ID_State = $ID_State;

        return $this;
    }

    public function getCodJobTitle(): ?JobTitle
    {
        return $this->Cod_JobTitle;
    }

    public function setCodJobTitle(?JobTitle $Cod_JobTitle): static
    {
        $this->Cod_JobTitle = $Cod_JobTitle;

        return $this;
    }

    public function getIdSchedule(): ?schedule
    {
        return $this->Id_schedule;
    }

    public function setIdSchedule(?schedule $Id_schedule): static
    {
        $this->Id_schedule = $Id_schedule;

        return $this;
    }

}
