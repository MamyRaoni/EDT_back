<?php

namespace App\Entity;

use App\Repository\ParcoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcoursRepository::class)]
class Parcours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle_parcours = null;

    /**
     * @var Collection<int, Matiere>
     */
    #[ORM\ManyToMany(targetEntity: Matiere::class, mappedBy: 'id_parcours')]
    private Collection $matieres;

    #[ORM\ManyToOne(inversedBy: 'id_parcours')]
    private ?Mention $mention = null;

    /**
     * @var Collection<int, classe>
     */
    #[ORM\ManyToMany(targetEntity: classe::class, inversedBy: 'parcours')]
    private Collection $id_classe;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
        $this->id_classe = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matiere $matiere): static
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->addIdParcour($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            $matiere->removeIdParcour($this);
        }

        return $this;
    }

    public function getMention(): ?Mention
    {
        return $this->mention;
    }

    public function setMention(?Mention $mention): static
    {
        $this->mention = $mention;

        return $this;
    }

    /**
     * @return Collection<int, classe>
     */
    public function getIdClasse(): Collection
    {
        return $this->id_classe;
    }

    public function addIdClasse(classe $idClasse): static
    {
        if (!$this->id_classe->contains($idClasse)) {
            $this->id_classe->add($idClasse);
        }

        return $this;
    }

    public function removeIdClasse(classe $idClasse): static
    {
        $this->id_classe->removeElement($idClasse);

        return $this;
    }
}
