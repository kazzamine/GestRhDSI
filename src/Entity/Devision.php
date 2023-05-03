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

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $type_devision = null;

    #[ORM\ManyToOne(inversedBy: 'devisions')]
    private ?Direction $direction = null;

    #[ORM\OneToMany(mappedBy: 'devision', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\ManyToOne(inversedBy: 'devision')]
    private ?Personnel $personnels_dev = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
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

    public function getTypeDevision(): ?string
    {
        return $this->type_devision;
    }

    public function setTypeDevision(?string $type_devision): self
    {
        $this->type_devision = $type_devision;

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

    public function getPersonnelsDev(): ?Personnel
    {
        return $this->personnels_dev;
    }

    public function setPersonnelsDev(?Personnel $personnels_dev): self
    {
        $this->personnels_dev = $personnels_dev;

        return $this;
    }
}
