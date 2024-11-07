<?php

namespace App\Controller;

use App\Entity\EmploiDuTemps;
use App\Repository\ClasseRepository;
use App\Repository\ContrainteRepository;
use App\Repository\EmploiDuTempsRepository;
use App\Service\TimetableService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class GenerationEmploiDuTempsController extends AbstractController
{
    #[Route('api/generationEDT', name: 'app_generation_emploi_du_temps', methods:['POST'])]
    public function index(TimetableService $timetableService, ClasseRepository $classeRepository, Request $request, EntityManagerInterface $em, ContrainteRepository $contrainteRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $classes = $classeRepository->find($data['classe']); // Remplir avec les données des classes
        
        $study_days = [
            '2024-03-18', // Lundi
            '2024-03-19', // Mardi
            '2024-03-20', // Mercredi
            '2024-03-21', // Jeudi
            '2024-03-22',  // Vendredi
            '2024-03-23'  // Samedi

        ]; // Remplir avec les jours d'étude(normalement envoie dpar l'utilisateur)
        $schedule = [];
        
        //dump($emploiDuTempsData);
        
       
            
        
        dump($schedule);
        $success = $timetableService->generateTimetable($classes, $study_days,$schedule);
        dump($success);
        dump($schedule);

        if ($success) {
            /*
            ovana le contrainte anle prof ampina mo zany ee manao $schedule[prof_id] de ovana ny contrainte anlery 
            manao switch case ndrepany fa le heure de debut fotsn defa ampy et si 
            */
            foreach ($schedule as $horaire) {
                $contrainte = $contrainteRepository->findOneBy([
                    'professeur' => $horaire['prof_id'],
                    'jour' => new \DateTime($horaire['jour']),
                ]);
                if ($contrainte) {
                    /* 
                    Traitement de la contrainte ici 
                    est c'est ici qu'on change la disponibilite du prof 
                    */
                    dump($contrainte);
                }
            }
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
    #[Route('/api/emploi-du-temps/vider', name: 'app_emploi_du_temps_vider', methods: ['DELETE'])]
    public function viderEmploiDuTemps(EntityManagerInterface $em, EmploiDuTempsRepository $emploiDuTempsRepository)
    {
        $emploiDuTemps = $emploiDuTempsRepository->findAll();
        foreach ($emploiDuTemps as $edt) {
            $em->remove($edt);
        }
        $em->flush();
        return $this->json([
            'message' => 'La table emploi_du_temps a été vidée avec succès.',
        ]);
    }
}