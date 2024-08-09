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

    /**
     * @var Collection<int, JobTitle>
     */
    #[ORM\OneToMany(targetEntity: JobTitle::class, mappedBy: 'Cod_JobTitle')]
    private Collection $Cod_JobTitle;

    /**
     * @var Collection<int, State>
     */
    #[ORM\OneToMany(targetEntity: State::class, mappedBy: 'Id_State')]
    private Collection $Id_State;

    /**
     * @var Collection<int, schedule>
     */
    #[ORM\OneToMany(targetEntity: schedule::class, mappedBy: 'Id_schedule')]
    private Collection $Id_schedule;

    #[ORM\ManyToOne(inversedBy: 'Id_employee')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nomina $Id_employee = null;

    public function __construct()
    {
        $this->Cod_JobTitle = new ArrayCollection();
        $this->Id_State = new ArrayCollection();
        $this->Id_schedule = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, JobTitle>
     */
    public function getCodJobTitle(): Collection
    {
        return $this->Cod_JobTitle;
    }

    public function addCodJobTitle(JobTitle $codJobTitle): static
    {
        if (!$this->Cod_JobTitle->contains($codJobTitle)) {
            $this->Cod_JobTitle->add($codJobTitle);
            $codJobTitle->setCodJobTitle($this);
        }

        return $this;
    }

    public function removeCodJobTitle(JobTitle $codJobTitle): static
    {
        if ($this->Cod_JobTitle->removeElement($codJobTitle)) {
            // set the owning side to null (unless already changed)
            if ($codJobTitle->getCodJobTitle() === $this) {
                $codJobTitle->setCodJobTitle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, State>
     */
    public function getIdState(): Collection
    {
        return $this->Id_State;
    }

    public function addIdState(State $idState): static
    {
        if (!$this->Id_State->contains($idState)) {
            $this->Id_State->add($idState);
            $idState->setIdState($this);
        }

        return $this;
    }

    public function removeIdState(State $idState): static
    {
        if ($this->Id_State->removeElement($idState)) {
            // set the owning side to null (unless already changed)
            if ($idState->getIdState() === $this) {
                $idState->setIdState(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, schedule>
     */
    public function getIdSchedule(): Collection
    {
        return $this->Id_schedule;
    }

    public function addIdSchedule(schedule $idSchedule): static
    {
        if (!$this->Id_schedule->contains($idSchedule)) {
            $this->Id_schedule->add($idSchedule);
            $idSchedule->setIdSchedule($this);
        }

        return $this;
    }

    public function removeIdSchedule(schedule $idSchedule): static
    {
        if ($this->Id_schedule->removeElement($idSchedule)) {
            // set the owning side to null (unless already changed)
            if ($idSchedule->getIdSchedule() === $this) {
                $idSchedule->setIdSchedule(null);
            }
        }

        return $this;
    }

    public function getIdEmployee(): ?Nomina
    {
        return $this->Id_employee;
    }

    public function setIdEmployee(?Nomina $Id_employee): static
    {
        $this->Id_employee = $Id_employee;

        return $this;
    }
}
