<?php

namespace App\Entity;

use App\Repository\TypeHourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, nomina>
     */
    #[ORM\OneToMany(targetEntity: nomina::class, mappedBy: 'typeHour', orphanRemoval: true)]
    private Collection $id_hour;

    public function __construct()
    {
        $this->id_hour = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, nomina>
     */
    public function getIdHour(): Collection
    {
        return $this->id_hour;
    }

    public function addIdHour(nomina $idHour): static
    {
        if (!$this->id_hour->contains($idHour)) {
            $this->id_hour->add($idHour);
            $idHour->setTypeHour($this);
        }

        return $this;
    }

    public function removeIdHour(nomina $idHour): static
    {
        if ($this->id_hour->removeElement($idHour)) {
            // set the owning side to null (unless already changed)
            if ($idHour->getTypeHour() === $this) {
                $idHour->setTypeHour(null);
            }
        }

        return $this;
    }
}
