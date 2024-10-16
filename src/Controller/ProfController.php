<?php

namespace App\Controller;

use App\Entity\Professeur;
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
            $json = $serializer->serialize($prof, 'json');
            return new JsonResponse($json, 200, [], true);
    }
    #[Route('/api/prof', name: 'app_prof_create', methods:['POST'])]
    public function createProf(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $prof = $serializer->deserialize($request->getContent(), Professeur::class, 'json');
        $em->persist($prof);
        $em->flush();
        return $this->json($prof, 201, [], ['groups' => 'prof']);
    }
}
