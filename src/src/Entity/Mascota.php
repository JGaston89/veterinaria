<?php

namespace App\Entity;

use App\Repository\MascotaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MascotaRepository::class)]
class Mascota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idCliente = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $Raza = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaNac = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCliente(): ?int
    {
        return $this->idCliente;
    }

    public function setIdCliente(int $idCliente): self
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getRaza(): ?string
    {
        return $this->Raza;
    }

    public function setRaza(string $Raza): self
    {
        $this->Raza = $Raza;

        return $this;
    }

    public function getFechaNac(): ?\DateTimeInterface
    {
        return $this->FechaNac;
    }

    public function setFechaNac(\DateTimeInterface $FechaNac): self
    {
        $this->FechaNac = $FechaNac;

        return $this;
    }
}
