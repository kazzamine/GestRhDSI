<?php

namespace App\Entity;

use App\Repository\TypeCongeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'typeConge', targetEntity: Conge::class)]
    private Collection $conges;

    public function __construct()
    {
        $this->conges = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Conge>
     */
    public function getConges(): Collection
    {
        return $this->conges;
    }

    public function addConge(Conge $conge): self
    {
        if (!$this->conges->contains($conge)) {
            $this->conges->add($conge);
            $conge->setTypeConge($this);
        }

        return $this;
    }

    public function removeConge(Conge $conge): self
    {
        if ($this->conges->removeElement($conge)) {
            // set the owning side to null (unless already changed)
            if ($conge->getTypeConge() === $this) {
                $conge->setTypeConge(null);
            }
        }

        return $this;
    }
}
