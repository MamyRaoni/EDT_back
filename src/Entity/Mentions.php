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
    #[Groups(['classe:read'])]
    private ?string $libelle_mention = null;

    /**
     * @var Collection<int, Classes>
     */
    #[ORM\OneToMany(targetEntity: Classes::class, mappedBy: 'mention')]
    private Collection $classes;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
    }

    

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

    /**
     * @return Collection<int, Classes>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classes $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
            $class->setMention($this);
        }

        return $this;
    }

    public function removeClass(Classes $class): static
    {
        if ($this->classes->removeElement($class)) {
            // set the owning side to null (unless already changed)
            if ($class->getMention() === $this) {
                $class->setMention(null);
            }
        }

        return $this;
    }

   
}
