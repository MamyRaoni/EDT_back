<?php

namespace App\Entity;

use App\Repository\ContrainteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContrainteRepository::class)]
class Contraintes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getProfesseur'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Groups(['getProfesseur'])]
    private array $disponibilite = [];

    #[ORM\ManyToOne(inversedBy: 'contraintes')]
    #[Groups(['getProfesseur'])]
    private ?Professeurs $professeur = null;

    #[ORM\Column(length:255)]
    #[Groups(['getProfesseur'])]
    private ?string $jour = null;

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

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

   


}
