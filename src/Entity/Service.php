<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom_service = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description_service = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $respo_service = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?Devision $devision = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: Personnel::class)]
    private Collection $personnels_ser;

    public function __construct()
    {
        $this->personnels_ser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomService(): ?string
    {
        return $this->nom_service;
    }

    public function setNomService(string $nom_service): self
    {
        $this->nom_service = $nom_service;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->description_service;
    }

    public function setDescriptionService(?string $description_service): self
    {
        $this->description_service = $description_service;

        return $this;
    }

    public function getRespoService(): ?string
    {
        return $this->respo_service;
    }

    public function setRespoService(?string $respo_service): self
    {
        $this->respo_service = $respo_service;

        return $this;
    }

    public function getDevision(): ?Devision
    {
        return $this->devision;
    }

    public function setDevision(?Devision $devision): self
    {
        $this->devision = $devision;

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnelsSer(): Collection
    {
        return $this->personnels_ser;
    }

    public function addPersonnelsSer(Personnel $personnelsSer): self
    {
        if (!$this->personnels_ser->contains($personnelsSer)) {
            $this->personnels_ser->add($personnelsSer);
            $personnelsSer->setService($this);
        }

        return $this;
    }

    public function removePersonnelsSer(Personnel $personnelsSer): self
    {
        if ($this->personnels_ser->removeElement($personnelsSer)) {
            // set the owning side to null (unless already changed)
            if ($personnelsSer->getService() === $this) {
                $personnelsSer->setService(null);
            }
        }

        return $this;
    }
}
