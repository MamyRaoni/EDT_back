<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['classe:read'])]
    private ?string $niveau = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $designation): static
    {
        $this->niveau = $designation;

        return $this;
    }
}
