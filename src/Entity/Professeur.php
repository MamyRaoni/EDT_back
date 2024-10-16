<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $grade = null;

    #[ORM\Column(length: 10)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255)]
    private ?string $contact = null;

    /**
     * @var Collection<int, Matiere>
     */
    #[ORM\OneToMany(targetEntity: Matiere::class, mappedBy: 'id_prof')]
    private Collection $matieres;

    /**
     * @var Collection<int, Contrainte>
     */
    #[ORM\OneToMany(targetEntity: Contrainte::class, mappedBy: 'id_prof')]
    private Collection $contraintes;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
        $this->contraintes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

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
            $matiere->setIdProf($this);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getIdProf() === $this) {
                $matiere->setIdProf(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contrainte>
     */
    public function getContraintes(): Collection
    {
        return $this->contraintes;
    }

    public function addContrainte(Contrainte $contrainte): static
    {
        if (!$this->contraintes->contains($contrainte)) {
            $this->contraintes->add($contrainte);
            $contrainte->setIdProf($this);
        }

        return $this;
    }

    public function removeContrainte(Contrainte $contrainte): static
    {
        if ($this->contraintes->removeElement($contrainte)) {
            // set the owning side to null (unless already changed)
            if ($contrainte->getIdProf() === $this) {
                $contrainte->setIdProf(null);
            }
        }

        return $this;
    }
}
