<?php

namespace App\Entity;
use App\Repository\ParcoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParcoursRepository::class)]
class Parcours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['classe:read'])]
    private ?string $libelle_parcours = null;

   

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleParcours(): ?string
    {
        return $this->libelle_parcours;
    }

    public function setLibelleParcours(string $libelle_parcours): static
    {
        $this->libelle_parcours = $libelle_parcours;

        return $this;
    }

   
}
