<?php

namespace App\Controller;

use App\Entity\EmploiDuTemps;
use App\Repository\ClasseRepository;
use App\Repository\ContrainteRepository;
use App\Repository\EmploiDuTempsRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\SalleRepository;
use App\Service\AddContrainteService;
use App\Service\ContrainteSnapshotService;
//use App\Service\TimetableService;
use App\Service\EmploiDuTempsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class GenerationEmploiDuTempsController extends AbstractController
{
    #[Route('api/generationEDT', name: 'app_generation_emploi_du_temps', methods:['POST'])]
    public function index(ClasseRepository $classeRepository, Request $request, EntityManagerInterface $em, AddContrainteService $addContrainteService, ContrainteRepository $contrainteRepository, EmploiDuTempsService $emploiDuTempsService, SalleRepository $salleRepository, ContrainteSnapshotService $contrainteSnapshotService,EmploiDuTempsRepository $emploiDuTempsRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $classes = $classeRepository->find($data['classe']);
        $salles= $salleRepository->findAll();
        $semestre=$data['semestre']; 
        $Toutmatieres=$classes->getMatieres()->toArray();
        $matieres=[];
        foreach($Toutmatieres as $matiere){
            if($matiere->getSemestre()==$semestre){
                $matieres[]=$matiere;
            }
        }// Remplir avec les données des classes
        //dd($matieres);
        $study_days = [
            '2024-03-18', // Lundi
            '2024-03-19', // Mardi
            '2024-03-20', // Mercredi
            '2024-03-21', // Jeudi
            '2024-03-22',  // Vendredi
            '2024-03-23'  // Samedi

        ]; 
        $schedule = [];
        $tour_matiere=[];
        $testTour1=[true];
        $tablEdt=$emploiDuTempsRepository->findAll();
        //$success = $timetableService->generateTimetable($classes, $study_days,$schedule,$semestre,$tour_matiere);
        $contrainteSnapshotService->exportContraintes();
        $success = $emploiDuTempsService->generateTimetable($classes, $study_days,$schedule,$semestre,$tour_matiere,$salles,$tablEdt,$testTour1,$matieres);
        if ($success) {
            /*
            ovana le contrainte anle prof ampina mo zany ee manao $schedule[prof_id] de ovana ny contrainte anlery 
            manao switch case ndrepany fa le heure de debut fotsn defa ampy et si 
            */
            $addContrainteService->fetchContrainte( $schedule,$contrainteRepository,$em);
            $edt=new EmploiDuTemps();
            $edt->setClasse($classes->getLibelleClasse());
            $edt->setTableau($schedule);
            $edt->setSemestre($semestre);
            $em->persist($edt);
            $em->flush();
            // return $this->json([
            //     'message' => 'Emploi du temps généré avec succès!'
            // ], 200, []);
            return $this->json(['message'=> 'generation de l\'emploi du temps avec success'], 200);
        } 
        else {
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
    #[Route('/api/regenerateContrainte', name:'app_regenrate_contrainte', methods:['GET'])]
    public function regenerateContrainte(ContrainteSnapshotService $contrainteSnapshotService, ProfesseurRepository $professeurRepository){
        $contrainteSnapshotService->importContraintes($professeurRepository);
        return $this->json([
            'message' => 'regeneration des contraintes effectuer avec sucess',
        ], 200);
    }
    /**
     * Vide la table emploi_du_temps.
     */
    #[Route('/api/videEmploiDuTemps', name: 'app_vide_emploi_du_temps', methods: ['DELETE'])]
    public function videEmploiDuTemps(EmploiDuTempsRepository $emploiDuTempsRepository, EntityManagerInterface $em)
    {
        $emploiDuTemps = $emploiDuTempsRepository->findAll();
        foreach ($emploiDuTemps as $edt) {
            $em->remove($edt);
        }
        $em->flush();
        return $this->json([
            'message' => 'La table emploi_du_temps a été vidée avec succès.',
        ], 200);
    }
    

}