<?php

namespace App\Entity;

use App\Repository\DirectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'direction', targetEntity: Devision::class)]
    private Collection $devisions;

    #[ORM\OneToMany(mappedBy: 'direction', targetEntity: Personnel::class)]
    private Collection $personnels_dir;

    public function __construct()
    {
        $this->devisions = new ArrayCollection();
        $this->personnels_dir = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Devision>
     */
    public function getDevisions(): Collection
    {
        return $this->devisions;
    }

    public function addDevision(Devision $devision): self
    {
        if (!$this->devisions->contains($devision)) {
            $this->devisions->add($devision);
            $devision->setDirection($this);
        }

        return $this;
    }

    public function removeDevision(Devision $devision): self
    {
        if ($this->devisions->removeElement($devision)) {
            // set the owning side to null (unless already changed)
            if ($devision->getDirection() === $this) {
                $devision->setDirection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnelsDir(): Collection
    {
        return $this->personnels_dir;
    }

    public function addPersonnelsDir(Personnel $personnelsDir): self
    {
        if (!$this->personnels_dir->contains($personnelsDir)) {
            $this->personnels_dir->add($personnelsDir);
            $personnelsDir->setDirection($this);
        }

        return $this;
    }

    public function removePersonnelsDir(Personnel $personnelsDir): self
    {
        if ($this->personnels_dir->removeElement($personnelsDir)) {
            // set the owning side to null (unless already changed)
            if ($personnelsDir->getDirection() === $this) {
                $personnelsDir->setDirection(null);
            }
        }

        return $this;
    }
}
