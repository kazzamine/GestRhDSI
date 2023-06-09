<?php

namespace App\Entity;

use App\Repository\VisitorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitorRepository::class)]
class Visitor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $visitorIp = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $visitorDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitorIp(): ?string
    {
        return $this->visitorIp;
    }

    public function setVisitorIp(string $visitorIp): self
    {
        $this->visitorIp = $visitorIp;

        return $this;
    }

    public function getVisitorDate(): ?\DateTimeInterface
    {
        return $this->visitorDate;
    }

    public function setVisitorDate(\DateTimeInterface $visitorDate): self
    {
        $this->visitorDate = $visitorDate;

        return $this;
    }
}
