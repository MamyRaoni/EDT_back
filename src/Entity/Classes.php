<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    private ?string $nombre_eleve = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Niveaux $niveau = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?Parcours $parcour = null;

    #[ORM\ManyToOne(inversedBy: 'classes')]
    private ?Mentions $mention = null;

    /**
     * @var Collection<int, Matieres>
     */
    #[ORM\ManyToMany(targetEntity: Matieres::class, mappedBy: 'classe')]
    private Collection $matieres;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
    }

    

    


    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getNombreEleve(): ?string
    {
        return $this->nombre_eleve;
    }

    public function setNombreEleve(string $nombre_eleve): static
    {
        $this->nombre_eleve = $nombre_eleve;

        return $this;
    }

    public function getNiveau(): ?Niveaux
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveaux $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getParcour(): ?Parcours
    {
        return $this->parcour;
    }

    public function setParcour(?Parcours $parcour): static
    {
        $this->parcour = $parcour;

        return $this;
    }

    public function getMention(): ?Mentions
    {
        return $this->mention;
    }

    public function setMention(?Mentions $mention): static
    {
        $this->mention = $mention;

        return $this;
    }

    /**
     * @return Collection<int, Matieres>
     */
    public function getMatieres(): Collection
    {
        return $this->matieres;
    }

    public function addMatiere(Matieres $matiere): static
    {
        if (!$this->matieres->contains($matiere)) {
            $this->matieres->add($matiere);
            $matiere->addClasse($this);
        }

        return $this;
    }

    public function removeMatiere(Matieres $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            $matiere->removeClasse($this);
        }

        return $this;
    }


    
}
