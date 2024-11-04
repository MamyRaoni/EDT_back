<?php

namespace App\Controller;

use App\Entity\Contrainte;
use App\Entity\Contraintes;
use App\Repository\ContrainteRepository;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ContrainteController extends AbstractController
{
    #[Route('/api/contrainte', name: 'app_contrainte', methods:['GET'])]
    public function getAllContrainte(ContrainteRepository $contrainteRepository, SerializerInterface $serializer): JsonResponse
    {
        $contrainte = $contrainteRepository->findAll();
        $json = $serializer->serialize($contrainte, 'json');
        return new JsonResponse($json, 200, [], true);
    }
    #[Route('/api/contrainte/{id}', name: 'app_contrainte_delete', methods:['DELETE'])  ]
    public function deleteContrainte(Contraintes $contrainte, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($contrainte);
        $em->flush();
        return $this->json(null, 204);
    }
    #[Route('/api/contrainte', name: 'app_contrainte_create', methods:['POST'])]
    public function createContrainte(Request $request, EntityManagerInterface $em, ProfesseurRepository $professeurRepository): JsonResponse
    {
        
        $data = json_decode($request->getContent(), true);
        $contrainte = new Contraintes();
        $professeur = $professeurRepository->find($data['professeur']);
        $contrainte->setJour(new \DateTime($data['jour']));
        $contrainte->setProfesseur($professeur);
        $em->persist($contrainte);
        $em->flush();
        return $this->json($contrainte, 201);
    }
}
