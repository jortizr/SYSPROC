<?php

namespace App\Entity\Inventory;

use App\Repository\Inventory\deviceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: deviceRepository::class)]
class device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $brand = null;

    #[ORM\Column(length: 50)]
    private ?string $model = null;

    #[ORM\Column(nullable: true)]
    private ?bool $changer = null;

    #[ORM\Column(length: 60)]
    private ?string $create_by = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modified_date = null;

    #[ORM\Column(length: 50)]
    private ?string $modified_by = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function isChanger(): ?bool
    {
        return $this->changer;
    }

    public function setChanger(?bool $changer): static
    {
        $this->changer = $changer;

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

    public function getModifiedDate(): ?\DateTimeInterface
    {
        return $this->modified_date;
    }

    public function setModifiedDate(?\DateTimeInterface $modified_date): static
    {
        $this->modified_date = $modified_date;

        return $this;
    }

    public function getModifiedBy(): ?string
    {
        return $this->modified_by;
    }

    public function setModifiedBy(string $modified_by): static
    {
        $this->modified_by = $modified_by;

        return $this;
    }
}
