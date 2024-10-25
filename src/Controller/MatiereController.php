<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Repository\MatiereRepository;
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
    public function createMatiere(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $matiere = $serializer->deserialize($request->getContent(), Matiere::class, 'json');
        $em->persist($matiere);
        $em->flush();
        return $this->json($matiere, 201, [], ['groups' => 'matiere']);
    }
}
