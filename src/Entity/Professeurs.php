<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getProfesseur'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getProfesseur'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getProfesseur'])]
    private ?string $grade = null;

    #[ORM\Column(length: 10)]
    #[Groups(['getProfesseur'])]
    private ?string $sexe = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getProfesseur'])]
    private ?string $contact = null;

    /**
     * @var Collection<int, Contraintes>
     */
    #[ORM\OneToMany(targetEntity: Contraintes::class, mappedBy: 'professeur', cascade: ['persist', 'remove'])]
    private Collection $contraintes;

    /**
     * @var Collection<int, Matieres>
     */
    #[ORM\OneToMany(targetEntity: Matieres::class, mappedBy: 'professeur')]
    private Collection $matieres;

    public function __construct()
    {
        $this->contraintes = new ArrayCollection();
        $this->matieres = new ArrayCollection();
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
     * @return Collection<int, Contraintes>
     */
    public function getContraintes(): Collection
    {
        return $this->contraintes;
    }

    public function addContrainte(Contraintes $contrainte): static
    {
        if (!$this->contraintes->contains($contrainte)) {
            $this->contraintes->add($contrainte);
            $contrainte->setProfesseur($this);
        }

        return $this;
    }

    public function removeContrainte(Contraintes $contrainte): static
    {
        if ($this->contraintes->removeElement($contrainte)) {
            // set the owning side to null (unless already changed)
            if ($contrainte->getProfesseur() === $this) {
                $contrainte->setProfesseur(null);
            }
        }

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
            $matiere->setProfesseur($this);
        }

        return $this;
    }

    public function removeMatiere(Matieres $matiere): static
    {
        if ($this->matieres->removeElement($matiere)) {
            // set the owning side to null (unless already changed)
            if ($matiere->getProfesseur() === $this) {
                $matiere->setProfesseur(null);
            }
        }

        return $this;
    }
}
