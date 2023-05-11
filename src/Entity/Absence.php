<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbsenceRepository::class)]
class Absence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_absence = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_absence = null;


    #[ORM\Column(length: 255)]
    private ?string $justification = null;

    #[ORM\ManyToOne(inversedBy: 'absences')]
    private ?Personnel $employe_abse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAbsence(): ?string
    {
        return $this->type_absence;
    }

    public function setTypeAbsence(string $type_absence): self
    {
        $this->type_absence = $type_absence;

        return $this;
    }

    public function getDateAbsence(): ?\DateTimeInterface
    {
        return $this->date_absence;
    }

    public function setDateAbsence(\DateTimeInterface $date_absence): self
    {
        $this->date_absence = $date_absence;

        return $this;
    }


    public function getJustification(): ?string
    {
        return $this->justification;
    }

    public function setJustification(string $justification): self
    {
        $this->justification = $justification;

        return $this;
    }

    public function getEmployeAbse(): ?Personnel
    {
        return $this->employe_abse;
    }

    public function setEmployeAbse(?Personnel $employe_abse): self
    {
        $this->employe_abse = $employe_abse;

        return $this;
    }
}
