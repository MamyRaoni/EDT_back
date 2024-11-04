<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getClasse'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getClasse'])]
    private ?string $nombre_eleve = null;

    

    /**
     * @var Collection<int, Matieres>
     */
    #[ORM\ManyToMany(targetEntity: Matieres::class, mappedBy: 'classe')]
    private Collection $matieres;

    #[ORM\Column(length: 255)]
    #[Groups(['getClasse'])]
    private ?string $libelle_classe = null;

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

    public function getLibelleClasse(): ?string
    {
        return $this->libelle_classe;
    }

    public function setLibelleClasse(string $libelle_classe): static
    {
        $this->libelle_classe = $libelle_classe;

        return $this;
    }


    
}
