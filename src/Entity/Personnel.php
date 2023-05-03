<?php

namespace App\Entity;

use App\Repository\PersonnelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnelRepository::class)]
class Personnel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom_perso = null;

    #[ORM\Column(length: 150)]
    private ?string $prenom_perso = null;

    #[ORM\Column(length: 50)]
    private ?string $CIN = null;

    #[ORM\Column(length: 255)]
    private ?string $PPR = null;

    #[ORM\Column(length: 20)]
    private ?string $sexe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naiss = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 100)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Grade $grade = null;

    #[ORM\ManyToOne(inversedBy: 'personnels')]
    private ?Poste $poste = null;

    #[ORM\ManyToOne(inversedBy: 'personnels_ser')]
    private ?Service $service = null;

    #[ORM\OneToMany(mappedBy: 'personnels_dev', targetEntity: Devision::class)]
    private Collection $devision;

    #[ORM\ManyToOne(inversedBy: 'personnels_dir')]
    private ?Direction $direction = null;

    #[ORM\ManyToOne(inversedBy: 'personnels_acad')]
    private ?Academie $academie = null;

    public function __construct()
    {
        $this->devision = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPerso(): ?string
    {
        return $this->nom_perso;
    }

    public function setNomPerso(string $nom_perso): self
    {
        $this->nom_perso = $nom_perso;

        return $this;
    }

    public function getPrenomPerso(): ?string
    {
        return $this->prenom_perso;
    }

    public function setPrenomPerso(string $prenom_perso): self
    {
        $this->prenom_perso = $prenom_perso;

        return $this;
    }

    public function getCIN(): ?string
    {
        return $this->CIN;
    }

    public function setCIN(string $CIN): self
    {
        $this->CIN = $CIN;

        return $this;
    }

    public function getPPR(): ?string
    {
        return $this->PPR;
    }

    public function setPPR(string $PPR): self
    {
        $this->PPR = $PPR;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->date_naiss;
    }

    public function setDateNaiss(\DateTimeInterface $date_naiss): self
    {
        $this->date_naiss = $date_naiss;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection<int, Devision>
     */
    public function getDevision(): Collection
    {
        return $this->devision;
    }

    public function addDevision(Devision $devision): self
    {
        if (!$this->devision->contains($devision)) {
            $this->devision->add($devision);
            $devision->setPersonnelsDev($this);
        }

        return $this;
    }

    public function removeDevision(Devision $devision): self
    {
        if ($this->devision->removeElement($devision)) {
            // set the owning side to null (unless already changed)
            if ($devision->getPersonnelsDev() === $this) {
                $devision->setPersonnelsDev(null);
            }
        }

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

    public function getAcademie(): ?Academie
    {
        return $this->academie;
    }

    public function setAcademie(?Academie $academie): self
    {
        $this->academie = $academie;

        return $this;
    }
}
