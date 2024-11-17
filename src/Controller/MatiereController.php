<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Entity\Matieres;
use App\Repository\ClasseRepository;
use App\Repository\MatiereRepository;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MatiereController extends AbstractController
{
    #[Route('/api/matiere', name: 'app_matiere', methods:['GET'])]
    public function getAllMatiere(MatiereRepository $matiereRepository, SerializerInterface $serializer): JsonResponse
    {
        $matiere=$matiereRepository->findAll();
        $json = $serializer->serialize($matiere, 'json', ['groups' =>['getClasse', 'getProfesseur']]);
        return new JsonResponse($json, 200, [], true);
    }
    #[Route('/api/matiere', name: 'app_matiere_create', methods:['POST'])]
    public function createMatiere(Request $request, EntityManagerInterface $em, ClasseRepository $classeRepository, ProfesseurRepository $professeurRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $matiere=new Matieres();
        $classe=$classeRepository->find($data['classe']);
        $prof=$professeurRepository->find($data['professeur']);
        $matiere->setLibelle($data['libelle']);
        $matiere->setVolumeHoraire($data['volume_horaire']);
        $matiere->setVolumeHoraireRestant($data['volume_horaire_restant']);
        $matiere->setSemestre($data['semestre']);
        $matiere->setActivation($data['activation']);
        $matiere->addClasse($classe);
        $matiere->setProfesseur($prof);
        $em->persist($matiere);
        $em->flush();
        return $this->json($matiere, 201,[], ['groups' =>['getClasse', 'getProfesseur']]);
    }
    #[Route('/api/matiere/{id}', name: 'app_matiere_update', methods:['PATCH'])]
    public function updateMatiere(int $id, Request $request, EntityManagerInterface $em, MatiereRepository $matiereRepository, ClasseRepository $classeRepository, ProfesseurRepository $professeurRepository): JsonResponse
    {
        $matiere = $matiereRepository->find($id);
        if (!$matiere) {
            throw $this->createNotFoundException('La matière avec l\'id ' . $id . ' n\'existe pas');
        }
        $data = json_decode($request->getContent(), true);
        if (isset($data['libelle'])) {
            $matiere->setLibelle($data['libelle']);
        }
        if (isset($data['volume_horaire'])) {
            $matiere->setVolumeHoraire($data['volume_horaire']);
        }
        if (isset($data['volume_horaire_restant'])) {
            $matiere->setVolumeHoraireRestant($data['volume_horaire_restant']);
        }
        if (isset($data['semestre'])) {
            $matiere->setSemestre($data['semestre']);
        }
        if (isset($data['activation'])) {
            $matiere->setActivation($data['activation']);
        }
        if (isset($data['classe'])) {
            $classe = $classeRepository->find($data['classe']);
            $matiere->addClasse($classe);
        }
        if (isset($data['professeur'])) {
            $prof = $professeurRepository->find($data['professeur']);
            $matiere->setProfesseur($prof);
        }
        $em->flush();
        return $this->json($matiere, 200, [], ['groups' =>['getClasse', 'getProfesseur']]);
    }
    #[Route('/api/matiere/{id}', name: 'app_matiere_delete', methods:['DELETE'])]
    public function deleteMatiere(int $id, EntityManagerInterface $em, MatiereRepository $matiereRepository): JsonResponse
    {
        $matiere = $matiereRepository->find($id);
        if (!$matiere) {
            throw $this->createNotFoundException('La matière avec l\'id ' . $id . ' n\'existe pas');
        }
        $em->remove($matiere);
        $em->flush();
        return $this->json(null, 204);
    }
}


