<?php

namespace App\Entity;

use App\Repository\JourFerierRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JourFerierRepository::class)]
class JourFerier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomJour = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut_jour = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin_jour = null;

    #[ORM\Column]
    private ?int $duree = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomJour(): ?string
    {
        return $this->nomJour;
    }

    public function setNomJour(string $nomJour): self
    {
        $this->nomJour = $nomJour;

        return $this;
    }

    public function getDateDebutJour(): ?\DateTimeInterface
    {
        return $this->date_debut_jour;
    }

    public function setDateDebutJour(\DateTimeInterface $date_debut_jour): self
    {
        $this->date_debut_jour = $date_debut_jour;

        return $this;
    }

    public function getDateFinJour(): ?\DateTimeInterface
    {
        return $this->date_fin_jour;
    }

    public function setDateFinJour(\DateTimeInterface $date_fin_jour): self
    {
        $this->date_fin_jour = $date_fin_jour;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }
}
