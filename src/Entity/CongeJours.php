<?php

namespace App\Entity;

use App\Repository\CongeJoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CongeJoursRepository::class)]
class CongeJours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Personnel $personnelcin;

    #[ORM\Column]
    private ?int $nombreCongeNormal = null;

    #[ORM\Column]
    private ?int $nombreCongeExcep = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonnelcin(): ?Personnel
    {
        return $this->personnelcin;
    }

    public function setPersonnelcin(?Personnel $personnelcin): self
    {
        $this->personnelcin = $personnelcin;

        return $this;
    }

    public function getNombreCongeNormal(): ?int
    {
        return $this->nombreCongeNormal;
    }

    public function setNombreCongeNormal(int $nombreCongeNormal): self
    {
        $this->nombreCongeNormal = $nombreCongeNormal;

        return $this;
    }

    public function getNombreCongeExcep(): ?int
    {
        return $this->nombreCongeExcep;
    }

    public function setNombreCongeExcep(int $nombreCongeExcep): self
    {
        $this->nombreCongeExcep = $nombreCongeExcep;

        return $this;
    }
}
