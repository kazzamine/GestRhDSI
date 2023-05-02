<?php

namespace App\Entity;

use App\Repository\DirectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DirectionRepository::class)]
class Direction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_direction = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'directions')]
    private ?Ministre $ministere_D = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDirection(): ?string
    {
        return $this->nom_direction;
    }

    public function setNomDirection(string $nom_direction): self
    {
        $this->nom_direction = $nom_direction;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getMinistereD(): ?Ministre
    {
        return $this->ministere_D;
    }

    public function setMinistereD(?Ministre $ministere_D): self
    {
        $this->ministere_D = $ministere_D;

        return $this;
    }
}
