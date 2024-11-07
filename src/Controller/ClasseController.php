<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Repository\ClasseRepository;
use App\Repository\MentionRepository;
use App\Repository\NiveauRepository;
use App\Repository\ParcoursRepository;
use Doctrine\ORM\EntityManagerInterface;
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
}
