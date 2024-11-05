<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\ContrainteRepository;
use App\Service\TimetableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GenerationEmploiDuTempsController extends AbstractController
{
    #[Route('api/generationEDT', name: 'app_generation_emploi_du_temps')]
    public function index(TimetableService $timetableService, ContrainteRepository $contrainteRepository, ClasseRepository $classeRepository): JsonResponse
    {
        $classes = $classeRepository->findAll(); // Remplir avec les données des classes
        $profs_availabilities = $contrainteRepository->findAll();
        $study_days = [
            '2024-03-18', // Lundi
            '2024-03-19', // Mardi
            '2024-03-20', // Mercredi
            '2024-03-21', // Jeudi
            '2024-03-22'  // Vendredi
        ]; // Remplir avec les jours d'étude

        $schedule = [];
        $success = $timetableService->generateTimetable($classes, $profs_availabilities, $study_days, $schedule);

        if ($success) {
            return $this->json([
                'message' => 'Emploi du temps généré avec succès!',
                'schedule' => $schedule,
            ]);
        } else {
            return $this->json([
                'message' => 'Échec de la génération de l\'emploi du temps.',
            ], 500);
        }
    }
}
