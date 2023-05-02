<?php

namespace App\Entity;

use App\Repository\AcademieRepository;
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
}
