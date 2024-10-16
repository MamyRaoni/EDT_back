<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SalleController extends AbstractController
{
    #[Route('/api/salle', name: 'app_salle', methods:['POST'])]
    public function createSalle(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
       $salle = $serializer->deserialize($request->getContent(), Salle::class, 'json');
       $em->persist($salle);
       $em->flush();
       return $this->json($salle, 201, [], ['groups' => 'salle']);
    }
    #[Route('/api/salle', name: 'app_salle', methods:['GET'])]
    public function getAllSalle(SalleRepository $salleRepository, SerializerInterface $serializer): JsonResponse
    {
        $salle = $salleRepository->findAll();
        $json = $serializer->serialize($salle, 'json');
        return new JsonResponse($json, 200, [], true);
    }
}
