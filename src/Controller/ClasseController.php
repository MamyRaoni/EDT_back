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
        $json = $serializer->serialize($classe, 'json', ['groups' => 'getProfesseur']);
        return new JsonResponse($json, 200, []);
    }
    #[Route('/api/classe', name: 'app_classe_create', methods:['POST'])]
    public function createClasse(Request $request, ParcoursRepository $parcoursRepository, MentionRepository $mentionRepository, NiveauRepository $niveauRepository,  EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $niveau=$niveauRepository->find($data['niveau']);
        $parcour=$parcoursRepository->find($data['parcour']);
        $mention=$mentionRepository->find($data['mention']);
        $classe =new Classes();
        $classe->setMention($mention);
        $classe->setNiveau($niveau);
        $classe->setParcour($parcour);
        $classe->setNombreEleve($data['nombre_eleve']);

        $em->persist($classe);
        $em->flush();
        return $this->json($classe, 201, [], ['groups' => 'classe:read']);
    }
}
