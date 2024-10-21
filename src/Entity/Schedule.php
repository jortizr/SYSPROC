<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $time_start = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $time_end = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_2_start = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_2_end = null;

    /**
     * @var Collection<int, Employee>
     */
    #[ORM\OneToMany(targetEntity: Employee::class, mappedBy: 'Id_schedule', orphanRemoval: true)]
    private Collection $employees;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $weekend_time_start = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $weekend_time_end = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $weekend_time_2_start = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $weekend_time_2_end = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $mod_date = null;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
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

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->time_start;
    }

    public function setTimeStart(\DateTimeInterface $time_start): static
    {
        $this->time_start = $time_start;

        return $this;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->time_end;
    }

    public function setTimeEnd(\DateTimeInterface $time_end): static
    {
        $this->time_end = $time_end;

        return $this;
    }

    public function getTime2Start(): ?\DateTimeInterface
    {
        return $this->time_2_start;
    }

    public function setTime2Start(?\DateTimeInterface $time_2_start): static
    {
        $this->time_2_start = $time_2_start;

        return $this;
    }

    public function getTime2End(): ?\DateTimeInterface
    {
        return $this->time_2_end;
    }

    public function setTime2End(?\DateTimeInterface $time_2_end): static
    {
        $this->time_2_end = $time_2_end;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): static
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setIdSchedule($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): static
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getIdSchedule() === $this) {
                $employee->setIdSchedule(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getWeekendTimeStart(): ?\DateTimeInterface
    {
        return $this->weekend_time_start;
    }

    public function setWeekendTimeStart(\DateTimeInterface $weekend_time_start): static
    {
        $this->weekend_time_start = $weekend_time_start;

        return $this;
    }

    public function getWeekendTimeEnd(): ?\DateTimeInterface
    {
        return $this->weekend_time_end;
    }

    public function setWeekendTimeEnd(\DateTimeInterface $weekend_time_end): static
    {
        $this->weekend_time_end = $weekend_time_end;

        return $this;
    }

    public function getWeekendTime2Start(): ?\DateTimeInterface
    {
        return $this->weekend_time_2_start;
    }

    public function setWeekendTime2Start(?\DateTimeInterface $weekend_time_2_start): static
    {
        $this->weekend_time_2_start = $weekend_time_2_start;

        return $this;
    }

    public function getWeekendTime2End(): ?\DateTimeInterface
    {
        return $this->weekend_time_2_end;
    }

    public function setWeekendTime2End(?\DateTimeInterface $weekend_time_2_end): static
    {
        $this->weekend_time_2_end = $weekend_time_2_end;

        return $this;
    }

    public function getModDate(): ?\DateTimeInterface
    {
        return $this->mod_date;
    }

    public function setModDate(): static
    {
        $this->mod_date = new \DateTime();

        return $this;
    }

}
