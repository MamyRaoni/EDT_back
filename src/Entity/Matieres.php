<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matieres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getProfesseur', 'getClasse'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getProfesseur', 'getClasse'])]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getProfesseur', 'getClasse'])]
    private ?string $volume_horaire = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getProfesseur', 'getClasse'])]
    private ?string $volume_horaire_restant = null;

    #[ORM\Column(length: 255)]
    #[Groups(['getProfesseur', 'getClasse'])]
    private ?string $semestre = null;

    #[ORM\Column]
    #[Groups(['getProfesseur', 'getClasse'])]
    private ?bool $activation = null;

    

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    #[Groups(['getClasse'])]
    private ?Professeurs $professeur = null;

    /**
     * @var Collection<int, Classes>
     */
    #[ORM\ManyToMany(targetEntity: Classes::class, inversedBy: 'matieres')]
    #[Groups(['getProfesseur'])]
    private Collection $classe;

    public function __construct()
    {
        $this->classe = new ArrayCollection();
    }

    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getVolumeHoraire(): ?string
    {
        return $this->volume_horaire;
    }

    public function setVolumeHoraire(string $volume_horaire): static
    {
        $this->volume_horaire = $volume_horaire;

        return $this;
    }

    public function getVolumeHoraireRestant(): ?string
    {
        return $this->volume_horaire_restant;
    }

    public function setVolumeHoraireRestant(string $volume_horaire_restant): static
    {
        $this->volume_horaire_restant = $volume_horaire_restant;

        return $this;
    }

    public function getSemestre(): ?string
    {
        return $this->semestre;
    }

    public function setSemestre(string $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function isActivation(): ?bool
    {
        return $this->activation;
    }

    public function setActivation(bool $activation): static
    {
        $this->activation = $activation;

        return $this;
    }


    public function getProfesseur(): ?Professeurs
    {
        return $this->professeur;
    }

    public function setProfesseur(?Professeurs $professeur): static
    {
        $this->professeur = $professeur;

        return $this;
    }

    /**
     * @return Collection<int, Classes>
     */
    public function getClasse(): Collection
    {
        return $this->classe;
    }

    public function addClasse(Classes $classe): static
    {
        if (!$this->classe->contains($classe)) {
            $this->classe->add($classe);
        }

        return $this;
    }
    

    public function removeClasse(Classes $classe): static
    {
        $this->classe->removeElement($classe);

        return $this;
    }

    

    
}
