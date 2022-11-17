<?php

namespace App\Entity;

use App\Repository\HistorialClinicoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistorialClinicoRepository::class)]
class HistorialClinico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Observaciones = null;

    #[ORM\Column(length: 255)]
    private ?string $Sintomas = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaSintomas = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaObservaciones = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObservaciones(): ?string
    {
        return $this->Observaciones;
    }

    public function setObservaciones(string $Observaciones): self
    {
        $this->Observaciones = $Observaciones;

        return $this;
    }

    public function getSintomas(): ?string
    {
        return $this->Sintomas;
    }

    public function setSintomas(string $Sintomas): self
    {
        $this->Sintomas = $Sintomas;

        return $this;
    }

    public function getFechaSintomas(): ?\DateTimeInterface
    {
        return $this->FechaSintomas;
    }

    public function setFechaSintomas(\DateTimeInterface $FechaSintomas): self
    {
        $this->FechaSintomas = $FechaSintomas;

        return $this;
    }

    public function getFechaObservaciones(): ?\DateTimeInterface
    {
        return $this->FechaObservaciones;
    }

    public function setFechaObservaciones(\DateTimeInterface $FechaObservaciones): self
    {
        $this->FechaObservaciones = $FechaObservaciones;

        return $this;
    }
}
