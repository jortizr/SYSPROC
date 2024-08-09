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

    /**
     * @var Collection<int, Employee>
     */
    #[ORM\OneToMany(targetEntity: Employee::class, mappedBy: 'Id_employee')]
    private Collection $Id_employee;

    /**
     * @var Collection<int, TypeHour>
     */
    #[ORM\OneToMany(targetEntity: TypeHour::class, mappedBy: 'Id_Hour')]
    private Collection $Id_Hour;

    public function __construct()
    {
        $this->Id_employee = new ArrayCollection();
        $this->Id_Hour = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Employee>
     */
    public function getIdEmployee(): Collection
    {
        return $this->Id_employee;
    }

    public function addIdEmployee(Employee $idEmployee): static
    {
        if (!$this->Id_employee->contains($idEmployee)) {
            $this->Id_employee->add($idEmployee);
            $idEmployee->setIdEmployee($this);
        }

        return $this;
    }

    public function removeIdEmployee(Employee $idEmployee): static
    {
        if ($this->Id_employee->removeElement($idEmployee)) {
            // set the owning side to null (unless already changed)
            if ($idEmployee->getIdEmployee() === $this) {
                $idEmployee->setIdEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TypeHour>
     */
    public function getIdHour(): Collection
    {
        return $this->Id_Hour;
    }

    public function addIdHour(TypeHour $idHour): static
    {
        if (!$this->Id_Hour->contains($idHour)) {
            $this->Id_Hour->add($idHour);
            $idHour->setIdHour($this);
        }

        return $this;
    }

    public function removeIdHour(TypeHour $idHour): static
    {
        if ($this->Id_Hour->removeElement($idHour)) {
            // set the owning side to null (unless already changed)
            if ($idHour->getIdHour() === $this) {
                $idHour->setIdHour(null);
            }
        }

        return $this;
    }
}
