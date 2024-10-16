<?php

namespace App\Entity;

use App\Repository\ContrainteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContrainteRepository::class)]
class Contrainte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $jour = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $timeslot = [];

    #[ORM\ManyToOne(inversedBy: 'contraintes')]
    private ?Professeur $id_prof = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTimeslot(): array
    {
        return $this->timeslot;
    }

    public function setTimeslot(array $timeslot): static
    {
        $this->timeslot = $timeslot;

        return $this;
    }

    public function getIdProf(): ?Professeur
    {
        return $this->id_prof;
    }

    public function setIdProf(?Professeur $id_prof): static
    {
        $this->id_prof = $id_prof;

        return $this;
    }
}
