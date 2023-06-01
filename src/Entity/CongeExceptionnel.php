<?php

namespace App\Entity;

use App\Repository\CongeExceptionnelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CongeExceptionnelRepository::class)]
class CongeExceptionnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeconge = null;

    #[ORM\Column]
    private ?int $duree = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeconge(): ?string
    {
        return $this->typeconge;
    }

    public function setTypeconge(string $typeconge): self
    {
        $this->typeconge = $typeconge;

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
