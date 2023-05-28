<?php

namespace App\Entity;

use App\Repository\CongeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CongeRepository::class)]
class Conge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut_conge = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin_conge = null;



    #[ORM\OneToMany(mappedBy: 'conge_demande', targetEntity: DemandeConge::class)]
    private Collection $demandeConges;

    #[ORM\ManyToOne(inversedBy: 'conges')]
    private ?TypeConge $typeConge = null;

    #[ORM\Column]
    private ?int $dureeConge = null;

    public function __construct()
    {
        $this->demandeConges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutConge(): ?\DateTimeInterface
    {
        return $this->date_debut_conge;
    }

    public function setDateDebutConge(\DateTimeInterface $date_debut_conge): self
    {
        $this->date_debut_conge = $date_debut_conge;

        return $this;
    }

    public function getDateFinConge(): ?\DateTimeInterface
    {
        return $this->date_fin_conge;
    }

    public function setDateFinConge(\DateTimeInterface $date_fin_conge): self
    {
        $this->date_fin_conge = $date_fin_conge;

        return $this;
    }

   

    /**
     * @return Collection<int, DemandeConge>
     */
    public function getDemandeConges(): Collection
    {
        return $this->demandeConges;
    }

    public function addDemandeConge(DemandeConge $demandeConge): self
    {
        if (!$this->demandeConges->contains($demandeConge)) {
            $this->demandeConges->add($demandeConge);
            $demandeConge->setCongeDemande($this);
        }

        return $this;
    }

    public function removeDemandeConge(DemandeConge $demandeConge): self
    {
        if ($this->demandeConges->removeElement($demandeConge)) {
            // set the owning side to null (unless already changed)
            if ($demandeConge->getCongeDemande() === $this) {
                $demandeConge->setCongeDemande(null);
            }
        }

        return $this;
    }

    public function getTypeConge(): ?TypeConge
    {
        return $this->typeConge;
    }

    public function setTypeConge(?TypeConge $typeConge): self
    {
        $this->typeConge = $typeConge;

        return $this;
    }

    public function getDureeConge(): ?int
    {
        return $this->dureeConge;
    }

    public function setDureeConge(int $dureeConge): self
    {
        $this->dureeConge = $dureeConge;

        return $this;
    }
}
