<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_contract = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_embauche = null;

    #[ORM\Column(length: 200)]
    private ?string $type_contract = null;

    #[ORM\Column(length: 255)]
    private ?string $num_contrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateContract(): ?\DateTimeInterface
    {
        return $this->Date_contract;
    }

    public function setDateContract(\DateTimeInterface $Date_contract): self
    {
        $this->Date_contract = $Date_contract;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->Date_embauche;
    }

    public function setDateEmbauche(\DateTimeInterface $Date_embauche): self
    {
        $this->Date_embauche = $Date_embauche;

        return $this;
    }

    public function getTypeContract(): ?string
    {
        return $this->type_contract;
    }

    public function setTypeContract(string $type_contract): self
    {
        $this->type_contract = $type_contract;

        return $this;
    }

    public function getNumContrat(): ?string
    {
        return $this->num_contrat;
    }

    public function setNumContrat(string $num_contrat): self
    {
        $this->num_contrat = $num_contrat;

        return $this;
    }
}
