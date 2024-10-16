<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255)]
    private ?string $volume_horaire = null;

    #[ORM\Column(length: 255)]
    private ?string $volume_horaire_restant = null;

    #[ORM\Column(length: 255)]
    private ?string $semestre = null;

    #[ORM\Column]
    private ?bool $activation = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    private ?Classe $id_classe = null;

    #[ORM\ManyToOne(inversedBy: 'matieres')]
    private ?Professeur $id_prof = null;

    /**
     * @var Collection<int, Parcours>
     */
    #[ORM\ManyToMany(targetEntity: Parcours::class, inversedBy: 'matieres')]
    private Collection $id_parcours;

    public function __construct()
    {
        $this->id_parcours = new ArrayCollection();
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

    public function getIdClasse(): ?Classe
    {
        return $this->id_classe;
    }

    public function setIdClasse(?Classe $id_classe): static
    {
        $this->id_classe = $id_classe;

        return $this;
    }

    public function getIdProf(): ?Professeur
    {
        return $this->id_prof;
    }

    public function setIdProf(?Professeur $id_prof): static
    {
        $this->id_prof = $id_prof;

        return $this;
    }

    /**
     * @return Collection<int, Parcours>
     */
    public function getIdParcours(): Collection
    {
        return $this->id_parcours;
    }

    public function addIdParcour(parcours $idParcour): static
    {
        if (!$this->id_parcours->contains($idParcour)) {
            $this->id_parcours->add($idParcour);
        }

        return $this;
    }

    public function removeIdParcour(parcours $idParcour): static
    {
        $this->id_parcours->removeElement($idParcour);

        return $this;
    }
}
