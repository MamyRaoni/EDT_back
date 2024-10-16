<?php

namespace App\Entity;

use App\Repository\MentionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MentionRepository::class)]
class Mention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle_mention = null;

    /**
     * @var Collection<int, Parcours>
     */
    #[ORM\OneToMany(targetEntity: Parcours::class, mappedBy: 'mention')]
    private Collection $id_parcours;

    public function __construct()
    {
        $this->id_parcours = new ArrayCollection();
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
     * @return Collection<int, Parcours>
     */
    public function getIdParcours(): Collection
    {
        return $this->id_parcours;
    }

    public function addIdParcour(Parcours $idParcour): static
    {
        if (!$this->id_parcours->contains($idParcour)) {
            $this->id_parcours->add($idParcour);
            $idParcour->setMention($this);
        }

        return $this;
    }

    public function removeIdParcour(Parcours $idParcour): static
    {
        if ($this->id_parcours->removeElement($idParcour)) {
            // set the owning side to null (unless already changed)
            if ($idParcour->getMention() === $this) {
                $idParcour->setMention(null);
            }
        }

        return $this;
    }
}
