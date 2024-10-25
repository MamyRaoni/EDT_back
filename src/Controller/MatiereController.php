<?php

namespace App\Controller;

use App\Entity\Matiere;
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
        $json = $serializer->serialize($matiere, 'json');
        return new JsonResponse($json, 200, [], true);
    }
    #[Route('/api/matiere', name: 'app_matiere_create', methods:['POST'])]
    public function createMatiere(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ClasseRepository $classeRepository, ProfesseurRepository $professeurRepository): JsonResponse
    {
        //il y a une reference circulaire dans l'entity Matiere avec la entity Classe ajouter l'annotation @group({"matiere"}) aux propriete du classe Matiere 
        // $matiere = $serializer->deserialize($request->getContent(), Matiere::class, 'json');
        // $em->persist($matiere);
        // $em->flush();
        // return $this->json($matiere, 201, [], ['groups' => 'matiere']);
        $data = json_decode($request->getContent(), true);
        $classe=$classeRepository->find($data['id_classe']);
        $prof=$professeurRepository->find($data['id_prof']);
        $matiere =$serializer->deserialize($request->getContent(), Matiere::class, 'json');
        // $matiere->setLibelle($data['libelle']);
        // $matiere->setVolumeHoraire($data['volume_horaire']);
        // $matiere->setVolumeHoraireRestant($data['volume_horaire_restant']);
        // $matiere->setSemestre($data['semestre']);
        // $matiere->setActivation($data['activation']);
        $matiere->setIdClasse($classe);
        $matiere->setIdProf($prof);
        $em->persist($matiere);
        $em->flush();
        return $this->json($matiere, 201);
        

    }
}
