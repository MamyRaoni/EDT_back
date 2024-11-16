<?php

namespace App\Controller;

use App\Entity\EmploiDuTemps;
use App\Repository\ClasseRepository;
use App\Repository\ContrainteRepository;
use App\Repository\EmploiDuTempsRepository;
use App\Service\AddContrainteService;
use App\Service\TimetableService;
use App\Service\EmploiDuTempsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class GenerationEmploiDuTempsController extends AbstractController
{
    #[Route('api/generationEDT', name: 'app_generation_emploi_du_temps', methods:['POST'])]
    public function index(ClasseRepository $classeRepository, Request $request, EntityManagerInterface $em, AddContrainteService $addContrainteService, ContrainteRepository $contrainteRepository, EmploiDuTempsService $emploiDuTempsService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $classes = $classeRepository->find($data['classe']);
        $semestre=$data['semestre']; // Remplir avec les données des classes
        
        $study_days = [
            '2024-03-18', // Lundi
            '2024-03-19', // Mardi
            '2024-03-20', // Mercredi
            '2024-03-21', // Jeudi
            '2024-03-22',  // Vendredi
            '2024-03-23'  // Samedi

        ]; // Remplir avec les jours d'étude(normalement envoie dpar l'utilisateur)
        $schedule = [];
        $tour_matiere=[];
        
      
        //$success = $timetableService->generateTimetable($classes, $study_days,$schedule,$semestre,$tour_matiere);
        $success = $emploiDuTempsService->generateTimetable($classes, $study_days,$schedule,$semestre,$tour_matiere);
        dump($success);
        dump($schedule);

        if ($success) {
            /*
            ovana le contrainte anle prof ampina mo zany ee manao $schedule[prof_id] de ovana ny contrainte anlery 
            manao switch case ndrepany fa le heure de debut fotsn defa ampy et si 
            */
            $addContrainteService->fetchContrainte( $schedule,$contrainteRepository,$em);
            $edt=new EmploiDuTemps();
            $edt->setClasse($classes->getLibelleClasse());
            $edt->setTableau($schedule);
            $em->persist($edt);
            $em->flush();
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
    /**
     * Vide la table emploi_du_temps.
     */
    #[Route('/api/generationEDT', name: 'app_emploi_du_temps_get', methods: ['GET'])]
    public function getEmploiDuTemps(EmploiDuTempsRepository $emploiDuTempsRepository)
    {
        $emploiDuTemps = $emploiDuTempsRepository->findAll();
        return $this->json($emploiDuTemps);
    }
}