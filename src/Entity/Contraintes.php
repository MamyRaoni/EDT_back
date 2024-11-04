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

    #[ORM\Column(type: Types::ARRAY)]
    private array $disponibilite = [];

    #[ORM\ManyToOne(inversedBy: 'contraintes')]
    private ?Professeurs $professeur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $jour = null;

     public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getDisponibilite(): array
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(array $disponibilite): static
    {
        $this->disponibilite = $disponibilite;

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

    public function getJour(): ?\DateTimeInterface
    {
        return $this->jour;
    }

    public function setJour(\DateTimeInterface $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

   


}
