<?php

namespace App\Entity;

use App\Repository\ContrainteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContrainteRepository::class)]
class Contraintes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateInterval $semaine = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $dosponibilite = [];

    #[ORM\ManyToOne(inversedBy: 'contraintes')]
    private ?Professeurs $professeur = null;

   

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSemaine(): ?\DateInterval
    {
        return $this->semaine;
    }

    public function setSemaine(\DateInterval $semaine): static
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getDosponibilite(): array
    {
        return $this->dosponibilite;
    }

    public function setDosponibilite(array $dosponibilite): static
    {
        $this->dosponibilite = $dosponibilite;

        return $this;
    }

    public function getProfesseur(): ?Professeurs
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeurs $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

   


}