<?php

namespace App\Entity;

use App\Repository\TypeCongeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeCongeRepository::class)]
class TypeConge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_conge = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeConge(): ?string
    {
        return $this->type_conge;
    }

    public function setTypeConge(string $type_conge): self
    {
        $this->type_conge = $type_conge;

        return $this;
    }
}
