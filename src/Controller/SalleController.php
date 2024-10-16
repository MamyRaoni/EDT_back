<?php

namespace App\Controller;

use App\Entity\Salle;
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
}
