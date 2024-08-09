<?php

namespace App\Entity;

use App\Repository\JobTitleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobTitleRepository::class)]
class JobTitle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'Cod_JobTitle')]
    private ?Employee $Cod_JobTitle = null;

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

    public function getCodJobTitle(): ?Employee
    {
        return $this->Cod_JobTitle;
    }

    public function setCodJobTitle(?Employee $Cod_JobTitle): static
    {
        $this->Cod_JobTitle = $Cod_JobTitle;

        return $this;
    }
}
