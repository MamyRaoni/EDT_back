<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Entity\Professeurs;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProfController extends AbstractController
{
    #[Route('/api/prof', name: 'app_prof', methods:['GET'])]
    public function getAllProf(ProfesseurRepository $profRepository,  SerializerInterface $serializer): JsonResponse
        {
            $prof = $profRepository->findAll();
            $json = $serializer->serialize($prof, 'json', ['groups' => 'getProfesseur']);
            return new JsonResponse($json, 200, [], true);
    }
    #[Route('/api/prof/{id}', name: 'app_prof_detail', methods:['GET'])]
    public function getDetailProf(Professeurs $prof, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($prof, 'json', ['groups' => 'getProfesseur']);
        return new JsonResponse($json, 200, [],true);
    }
    #[Route('/api/prof', name: 'app_prof_create', methods:['POST'])]
    public function createProf(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        /* rehefa mandefa anle data de mba atao format json tsara be amzay tsy sahirana ny back XD */
        $prof = $serializer->deserialize($request->getContent(), Professeurs::class, 'json');
        $em->persist($prof);
        $em->flush();
        return $this->json($prof, 201, [], ['groups' => 'getProfesseur']);
    }
    #[Route('/api/prof/{id}', name: 'app_prof_delete', methods:['DELETE'])]
    public function deleteProf(Professeurs $prof, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($prof);
        $em->flush();
        return $this->json(null, 204);
    }
    #[Route('/api/prof/{id}', name: 'app_prof_update', methods:['PATCH'])]
    public function updateProf(int $id, Request $request, EntityManagerInterface $em, ProfesseurRepository $profRepository, SerializerInterface $serializer): JsonResponse
    {
        $prof = $profRepository->find($id);
        if (!$prof) {
            throw $this->createNotFoundException('Le professeur avec l\'id ' . $id . ' n\'existe pas');
        }
        $data = json_decode($request->getContent(), true);
        if (isset($data['nom'])) {
            $prof->setNom($data['nom']);
        }
        
        if (isset($data['grade'])) {
            $prof->setGrade($data['grade']);
        }
        
        if (isset($data['sexe'])) {
            $prof->setSexe($data['sexe']);
        }

        if (isset($data['contact'])) {
            $prof->setContact($data['contact']);
        }
        
        $em->flush();
    
        return $this->json($prof, 200, [], ['groups' => 'getProfesseur']);
    }
    #[Route('/api/contrainte/prof/{id}', name: 'app_prof_detail', methods:['GET'])]
    public function getDetailProfcontrainte(int $id, ProfesseurRepository $professeurRepository, SerializerInterface $serializer): JsonResponse
    {
        $prof = $professeurRepository->find($id);
        if (!$prof) {
            throw $this->createNotFoundException('Le professeur avec l\'id ' . $id . ' n\'existe pas');
        }
        $matieres=$prof->getContraintes();
        $json = $serializer->serialize($matieres, 'json', ['groups' => 'getProfesseur']);
        return new JsonResponse($json, 200, [],true);
    }

    
}
