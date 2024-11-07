<?php

namespace App\Entity;

use App\Repository\EmploiDuTempsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmploiDuTempsRepository::class)]
class EmploiDuTemps
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $classe = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $tableau = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): static
    {
        $this->classe = $classe;

        return $this;
    }

    public function getTableau(): array
    {
        return $this->tableau;
    }

    public function setTableau(array $tableau): static
    {
        $this->tableau = $tableau;

        return $this;
    }
}
