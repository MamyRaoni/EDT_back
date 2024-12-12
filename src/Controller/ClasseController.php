<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Repository\ClasseRepository;
use App\Repository\MentionRepository;
use App\Repository\NiveauRepository;
use App\Repository\ParcoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\GroupBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ClasseController extends AbstractController
{
    #[Route('/api/classe', name: 'app_classe', methods:['GET'])]
    public function getAllContrainte(ClasseRepository $classeRepository, SerializerInterface $serializer): JsonResponse
    {
        $classe = $classeRepository->findAll();
        $json = $serializer->serialize($classe, 'json', ['groups' => 'getClasse']);
        return new JsonResponse($json, 200, [],true);
    }
    #[Route('/api/classe', name: 'app_classe_create', methods:['POST'])]
    public function createClasse(Request $request,  EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $response=[];
        foreach($data as $classData){
            $classe =$serializer->deserialize(json_encode($classData), Classes::class, 'json');
            $em->persist($classe);
            $response[]=$classe;
        }
        
        $em->flush();
        return $this->json($classe, 201);
    }
    #[Route('/api/classe/{id}', name: 'app_classe_update', methods:['PATCH'])]
    public function updateclasse(int $id, Request $request, EntityManagerInterface $em, ClasseRepository $classeRepository, SerializerInterface $serializer): JsonResponse
    {
        $classe = $classeRepository->find($id);
        if (!$classe) {
            throw $this->createNotFoundException('La classe avec l\'id ' . $id . ' n\'existe pas');
        }
        $data = json_decode($request->getContent(), true);
        if (isset($data['libelle_classe'])) {
            $classe->setLibelleClasse($data['libelle_classe']);
        }
        
        if (isset($data['nombre_eleve'])) {
            $classe->setNombreEleve($data['nombre_eleve']);
        }
        
        $em->flush();
        return new JsonResponse(["message"=>"modification reussi"], 201);
    }
    #[Route('/api/classe/{id}', name: 'app_classe_detail', methods:['GET'])]
    public function getDetailClasse(Classes $classe, SerializerInterface $serializer, ClasseRepository $classeRepository, $id): JsonResponse
    {
        $classe = $classeRepository->find($id);
        $json = $serializer->serialize($classe, 'json', ['groups' => 'getClasse']);
        return new JsonResponse($json, 200, [],true);
    }
}
