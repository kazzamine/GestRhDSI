<?php

namespace App\Entity;

use App\Repository\HoraireESRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireESRepository::class)]
class HoraireES
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_entre = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_sortie = null;

    #[ORM\ManyToMany(targetEntity: Personnel::class, inversedBy: 'Horaire')]
    private Collection $persoID;

    public function __construct()
    {
        $this->persoID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureEntre(): ?\DateTimeInterface
    {
        return $this->heure_entre;
    }

    public function setHeureEntre(\DateTimeInterface $heure_entre): self
    {
        $this->heure_entre = $heure_entre;

        return $this;
    }

    public function getHeureSortie(): ?\DateTimeInterface
    {
        return $this->heure_sortie;
    }

    public function setHeureSortie(\DateTimeInterface $heure_sortie): self
    {
        $this->heure_sortie = $heure_sortie;

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersoID(): Collection
    {
        return $this->persoID;
    }

    public function addPersoID(Personnel $persoID): self
    {
        if (!$this->persoID->contains($persoID)) {
            $this->persoID->add($persoID);
        }

        return $this;
    }

    public function removePersoID(Personnel $persoID): self
    {
        $this->persoID->removeElement($persoID);

        return $this;
    }
}
