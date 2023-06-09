<?php

namespace App\Entity;

use App\Repository\DemandeCongeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeCongeRepository::class)]
class DemandeConge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandeConges')]
    private ?Personnel $personnel_demande = null;

    #[ORM\ManyToOne(inversedBy: 'demandeConges')]
    private ?Conge $conge_demande = null;

    #[ORM\Column(length: 100)]
    private ?string $etatDemande = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reasonConge = null;

    #[ORM\Column(length: 100)]
    private ?string $adminApprove = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonnelDemande(): ?Personnel
    {
        return $this->personnel_demande;
    }

    public function setPersonnelDemande(?Personnel $personnel_demande): self
    {
        $this->personnel_demande = $personnel_demande;
        return $this;
    }

    public function getCongeDemande(): ?Conge
    {
        return $this->conge_demande;
    }

    public function setCongeDemande(?Conge $conge_demande): self
    {
        $this->conge_demande = $conge_demande;

        return $this;
    }

    public function getEtatDemande(): ?string
    {
        return $this->etatDemande;
    }

    public function setEtatDemande(string $etatDemande): self
    {
        $this->etatDemande = $etatDemande;

        return $this;
    }

    public function getReasonConge(): ?string
    {
        return $this->reasonConge;
    }

    public function setReasonConge(?string $reasonConge): self
    {
        $this->reasonConge = $reasonConge;

        return $this;
    }

    public function getAdminApprove(): ?string
    {
        return $this->adminApprove;
    }

    public function setAdminApprove(string $adminApprove): self
    {
        $this->adminApprove = $adminApprove;

        return $this;
    }
}
