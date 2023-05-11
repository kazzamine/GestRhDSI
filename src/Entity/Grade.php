<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom_grade = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'grade', targetEntity: Personnel::class)]
    private Collection $personnelsGrade;

    public function __construct()
    {
        $this->personnelsGrade = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGrade(): ?string
    {
        return $this->nom_grade;
    }

    public function setNomGrade(string $nom_grade): self
    {
        $this->nom_grade = $nom_grade;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnelsGrade(): Collection
    {
        return $this->personnelsGrade;
    }

    public function addPersonnelsGrade(Personnel $personnelsGrade): self
    {
        if (!$this->personnelsGrade->contains($personnelsGrade)) {
            $this->personnelsGrade->add($personnelsGrade);
            $personnelsGrade->setGrade($this);
        }

        return $this;
    }

    public function removePersonnelsGrade(Personnel $personnelsGrade): self
    {
        if ($this->personnelsGrade->removeElement($personnelsGrade)) {
            // set the owning side to null (unless already changed)
            if ($personnelsGrade->getGrade() === $this) {
                $personnelsGrade->setGrade(null);
            }
        }

        return $this;
    }
}
