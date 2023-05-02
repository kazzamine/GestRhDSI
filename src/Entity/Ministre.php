<?php

namespace App\Entity;

use App\Repository\MinistreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MinistreRepository::class)]
class Ministre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $nom_ministre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\OneToMany(mappedBy: 'ministre_Academie', targetEntity: Academie::class)]
    private Collection $academies;

    #[ORM\OneToMany(mappedBy: 'ministere_D', targetEntity: Direction::class)]
    private Collection $directions;

    public function __construct()
    {
        $this->academies = new ArrayCollection();
        $this->directions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMinistre(): ?string
    {
        return $this->nom_ministre;
    }

    public function setNomMinistre(string $nom_ministre): self
    {
        $this->nom_ministre = $nom_ministre;

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

    /**
     * @return Collection<int, Academie>
     */
    public function getAcademies(): Collection
    {
        return $this->academies;
    }

    public function addAcademy(Academie $academy): self
    {
        if (!$this->academies->contains($academy)) {
            $this->academies->add($academy);
            $academy->setMinistreAcademie($this);
        }

        return $this;
    }

    public function removeAcademy(Academie $academy): self
    {
        if ($this->academies->removeElement($academy)) {
            // set the owning side to null (unless already changed)
            if ($academy->getMinistreAcademie() === $this) {
                $academy->setMinistreAcademie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Direction>
     */
    public function getDirections(): Collection
    {
        return $this->directions;
    }

    public function addDirection(Direction $direction): self
    {
        if (!$this->directions->contains($direction)) {
            $this->directions->add($direction);
            $direction->setMinistereD($this);
        }

        return $this;
    }

    public function removeDirection(Direction $direction): self
    {
        if ($this->directions->removeElement($direction)) {
            // set the owning side to null (unless already changed)
            if ($direction->getMinistereD() === $this) {
                $direction->setMinistereD(null);
            }
        }

        return $this;
    }
}
