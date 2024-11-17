<?php

namespace App\Controller;

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
        $json = $serializer->serialize($contrainte, 'json', ['groups' => 'getProfesseur']);
        return new JsonResponse($json, 200,[], true);
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
        $response=[];
        foreach($data as $classData){
            $contrainte = new Contraintes();
            $professeur = $professeurRepository->find($classData['professeur']);
            $contrainte->setJour($classData['jour']);
            $contrainte->setProfesseur($professeur);
            $contrainte->setDisponibilite($classData['disponibilite']);
            $em->persist($contrainte);
            $response[]=$contrainte;
        }
        
        $em->flush();
        return $this->json($contrainte, 201,[], ['groups' => 'getProfesseur']);
    }
    #[Route('/api/contrainte/{id}', name: 'app_contrainte_update', methods:['PATCH'])]
    public function updateContrainte(int $id, Request $request, EntityManagerInterface $em, ContrainteRepository $contrainteRepository, ProfesseurRepository $professeurRepository): JsonResponse
    {
        $contrainte = $contrainteRepository->find($id);
        if (!$contrainte) {
            throw $this->createNotFoundException('La contrainte avec l\'id ' . $id . ' n\'existe pas');
        }
        $data = json_decode($request->getContent(), true);
        if (isset($data['jour'])) {
            $contrainte->setJour($data['jour']);
        }
        
        if (isset($data['disponibilite'])) {
            $contrainte->setDisponibilite($data['disponibilite']);
        }
        if (isset($data['professeur'])) {
            $professeur = $professeurRepository->find($data['professeur']);
            if (!$professeur) {
                throw $this->createNotFoundException('Le professeur avec l\'id ' . $data['professeur'] . ' n\'existe pas');
            }
            $contrainte->setProfesseur($professeur);
        }

        $em->flush();
    
        return $this->json($contrainte, 200, [], ['groups' => 'getProfesseur']);
    }
    #[Route('/api/contrainte/disponibilite', name: 'app_contrainte_disponibilite', methods:['POST'])]
    public function getContrainteByDateAndDisponibilite(Request $request, ContrainteRepository $contrainteRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $date = $data['date']; // Changement ici
        $disponibilite = $data['disponibilite'];// Changement ici
        $index=$data['index'];

        if (!$date || !isset($index) || !isset($disponibilite)) {
            return $this->json(['message' => 'La date, l\'index et la disponibilité sont obligatoires'], 400);
        }

        $contraintes = $contrainteRepository->findBy([
            'jour'=>$date
    ]);

        // Filtrer les contraintes en PHP
        $resultatsFiltres = array_filter($contraintes, function ($contrainte) use ($index, $disponibilite) {
            $disponibiliteArray = $contrainte->getDisponibilite(); // Récupérer le tableau de disponibilité
    
            // Vérifier si l'index existe dans le tableau et si la valeur est égale à la disponibilité attendue
            return is_array($disponibiliteArray) && isset($disponibiliteArray[$index]) && $disponibiliteArray[$index] === $disponibilite;
        });
    
        if (empty($resultatsFiltres)) {
            return $this->json(['message' => 'Aucune contrainte trouvée pour cette date et cette disponibilité'], 404);
        }
    
        return $this->json($resultatsFiltres, 200, [], ['groups' => 'getProfesseur']);
    }
}
