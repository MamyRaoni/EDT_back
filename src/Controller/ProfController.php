<?php

namespace App\Controller;

use App\Repository\ProfesseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}