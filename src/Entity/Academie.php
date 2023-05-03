<?php

namespace App\Entity;

use App\Repository\AcademieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcademieRepository::class)]
class Academie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom_academie = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;

    #[ORM\ManyToOne(inversedBy: 'academies')]
    private ?Ministre $ministre_Academie = null;

    #[ORM\OneToMany(mappedBy: 'academie', targetEntity: Personnel::class)]
    private Collection $personnels_acad;

    public function __construct()
    {
        $this->personnels_acad = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAcademie(): ?string
    {
        return $this->nom_academie;
    }

    public function setNomAcademie(string $nom_academie): self
    {
        $this->nom_academie = $nom_academie;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMinistreAcademie(): ?Ministre
    {
        return $this->ministre_Academie;
    }

    public function setMinistreAcademie(?Ministre $ministre_Academie): self
    {
        $this->ministre_Academie = $ministre_Academie;

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnelsAcad(): Collection
    {
        return $this->personnels_acad;
    }

    public function addPersonnelsAcad(Personnel $personnelsAcad): self
    {
        if (!$this->personnels_acad->contains($personnelsAcad)) {
            $this->personnels_acad->add($personnelsAcad);
            $personnelsAcad->setAcademie($this);
        }

        return $this;
    }

    public function removePersonnelsAcad(Personnel $personnelsAcad): self
    {
        if ($this->personnels_acad->removeElement($personnelsAcad)) {
            // set the owning side to null (unless already changed)
            if ($personnelsAcad->getAcademie() === $this) {
                $personnelsAcad->setAcademie(null);
            }
        }

        return $this;
    }
}
