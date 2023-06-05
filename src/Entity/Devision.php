<?php

namespace App\Entity;

use App\Repository\DevisionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisionRepository::class)]
class Devision
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_devision = null;

    #[ORM\ManyToOne(inversedBy: 'devisions')]
    private ?Direction $direction = null;

    #[ORM\OneToMany(mappedBy: 'devision', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\OneToMany(mappedBy: 'devision', targetEntity: Personnel::class)]
    private Collection $personnels;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Personnel $responsable = null;


    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->personnels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDevision(): ?string
    {
        return $this->nom_devision;
    }

    public function setNomDevision(string $nom_devision): self
    {
        $this->nom_devision = $nom_devision;

        return $this;
    }

    public function getDirection(): ?Direction
    {
        return $this->direction;
    }

    public function setDirection(?Direction $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setDevision($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getDevision() === $this) {
                $service->setDevision(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnels(): Collection
    {
        return $this->personnels;
    }

    public function addPersonnel(Personnel $personnel): self
    {
        if (!$this->personnels->contains($personnel)) {
            $this->personnels->add($personnel);
            $personnel->setDevision($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): self
    {
        if ($this->personnels->removeElement($personnel)) {
            // set the owning side to null (unless already changed)
            if ($personnel->getDevision() === $this) {
                $personnel->setDevision(null);
            }
        }

        return $this;
    }

    public function getResponsable(): ?Personnel
    {
        return $this->responsable;
    }

    public function setResponsable(?Personnel $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }
    


}
