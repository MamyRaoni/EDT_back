<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Entity\Salles;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SalleController extends AbstractController
{
    #[Route('/api/salle', name: 'app_salleAjouter', methods:['POST'])]
    public function createSalle(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse
    {
        $salle = $serializer->deserialize($request->getContent(), Salles::class, 'json');
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
    #[Route('/api/salle/{id}', name: 'app_salle_detail', methods:['GET'])]
    public function getDetailSalle(Salles $salle, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($salle, 'json');
        return new JsonResponse($json, 200, [], true);
    }
    #[Route('/api/salle/{id}', name: 'app_salle_delete', methods:['DELETE'])]
    public function deleteSalle(Salles $salle, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($salle);
        $em->flush();
        return $this->json(null, 204);
    }
}
