<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GenerationEmploiDuTempsController extends AbstractController
{
    #[Route('/generation/emploi/du/temps', name: 'app_generation_emploi_du_temps')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/GenerationEmploiDuTempsController.php',
        ]);
    }
}
