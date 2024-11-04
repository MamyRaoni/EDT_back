<?php

namespace App\Entity;

use App\Repository\MentionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MentionRepository::class)]
class Mentions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle_mention = null;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleMention(): ?string
    {
        return $this->libelle_mention;
    }

    public function setLibelleMention(string $libelle_mention): static
    {
        $this->libelle_mention = $libelle_mention;

        return $this;
    }

    

   
   
}
