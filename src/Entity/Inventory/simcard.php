<?php

namespace App\Entity\Inventory;

use App\Entity\State;
use App\Repository\Inventory\simcardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: simcardRepository::class)]
class simcard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name_operator = null;

    #[ORM\Column(length: 90, nullable: true)]
    private ?string $plan = null;

    #[ORM\Column(length: 60)]
    private ?string $create_by = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $modified_by = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modified_date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?State $State_simcard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameOperator(): ?string
    {
        return $this->name_operator;
    }

    public function setNameOperator(string $name_operator): static
    {
        $this->name_operator = $name_operator;

        return $this;
    }

    public function getPlan(): ?string
    {
        return $this->plan;
    }

    public function setPlan(?string $plan): static
    {
        $this->plan = $plan;

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

    public function getModifiedBy(): ?string
    {
        return $this->modified_by;
    }

    public function setModifiedBy(?string $modified_by): static
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

    public function getStateSimcard(): ?State
    {
        return $this->State_simcard;
    }

    public function setStateSimcard(?State $State_simcard): static
    {
        $this->State_simcard = $State_simcard;

        return $this;
    }
}
