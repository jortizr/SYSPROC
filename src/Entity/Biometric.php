<?php

namespace App\Entity;

use App\Repository\BiometricRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BiometricRepository::class)]
class Biometric
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $company = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    private ?string $cod_nomina = null;
    
    #[ORM\Column(nullable: true)]
    private ?int $cc = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $in_hour = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $out_hour = null;


    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $in_hour_2 = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $out_hour_2 = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $in_hour_3 = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $out_hour_3 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $holiday = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCodNomina(): ?string
    {
        return $this->cod_nomina;
    }

    public function setCodNomina(string $cod_nomina): static
    {
        $this->cod_nomina = $cod_nomina;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getInHour(): ?\DateTimeImmutable
    {
        return $this->in_hour;
    }

    public function setInHour(?\DateTimeImmutable $in_hour): static
    {
        $this->in_hour = $in_hour;

        return $this;
    }

    public function getCc(): ?int
    {
        return $this->cc;
    }

    public function setCc(?int $cc): static
    {
        $this->cc = $cc;

        return $this;
    }

    public function getOutHour(): ?\DateTimeImmutable
    {
        return $this->out_hour;
    }

    public function setOutHour(?\DateTimeImmutable $out_hour): static
    {
        $this->out_hour = $out_hour;

        return $this;
    }

    public function getInHour2(): ?\DateTimeImmutable
    {
        return $this->in_hour_2;
    }

    public function setInHour2(?\DateTimeImmutable $in_hour_2): static
    {
        $this->in_hour_2 = $in_hour_2;

        return $this;
    }

    public function getOutHour2(): ?\DateTimeImmutable
    {
        return $this->out_hour_2;
    }

    public function setOutHour2(?\DateTimeImmutable $out_hour_2): static
    {
        $this->out_hour_2 = $out_hour_2;

        return $this;
    }

    public function getInHour3(): ?\DateTimeImmutable
    {
        return $this->in_hour_3;
    }

    public function setInHour3(?\DateTimeImmutable $in_hour_3): static
    {
        $this->in_hour_3 = $in_hour_3;

        return $this;
    }

    public function getOutHour3(): ?\DateTimeImmutable
    {
        return $this->out_hour_3;
    }

    public function setOutHour3(?\DateTimeImmutable $out_hour_3): static
    {
        $this->out_hour_3 = $out_hour_3;

        return $this;
    }

    public function isHoliday(): ?bool
    {
        return $this->holiday;
    }

    public function setHoliday(?bool $holiday): static
    {
        $this->holiday = $holiday;

        return $this;
    }
}
