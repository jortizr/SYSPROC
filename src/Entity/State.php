<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateRepository::class)]
class State
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name_state = null;

    #[ORM\Column(length: 35)]
    private ?string $type_state = null;

    #[ORM\Column(length: 30)]
    private ?string $create_by = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modified_by = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modified_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameState(): ?string
    {
        return $this->name_state;
    }

    public function setNameState(string $name_state): static
    {
        $this->name_state = $name_state;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getNameState();
    }

    public function getTypeState(): ?string
    {
        return $this->type_state;
    }

    public function setTypeState(string $type_state): static
    {
        $this->type_state = $type_state;

        return $this;
    }

    public function getCreateBy(): ?string
    {
        return $this->create_by;
    }

    public function setCreateBy(string $create_by): static
    {
        $this->create_by = $create_by;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): static
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getModifiedBy(): ?\DateTimeInterface
    {
        return $this->modified_by;
    }

    public function setModifiedBy(?\DateTimeInterface $modified_by): static
    {
        $this->modified_by = $modified_by;

        return $this;
    }

    public function getModifiedDate(): ?\DateTimeInterface
    {
        return $this->modified_date;
    }

    public function setModifiedDate(?\DateTimeInterface $modified_date): static
    {
        $this->modified_date = $modified_date;

        return $this;
    }


}
