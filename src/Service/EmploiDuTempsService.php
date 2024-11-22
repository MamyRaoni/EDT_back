<?php
namespace App\Service;

use App\Entity\Classes;

class EmploiDuTempsService
{
    private SlotService $slotService;
    private ProfAvailabilityService $profAvailabilityService;
    private ClassBussyCheckerService $classBussyCheckerService;
    private AffectationSalleService $affectationSalleService;

    public function __construct(
        SlotService $slotService,
        ProfAvailabilityService $profAvailabilityService,
        ClassBussyCheckerService $classBussyCheckerService,
        AffectationSalleService $affectationSalleService
    ) {
        $this->slotService = $slotService;
        $this->profAvailabilityService = $profAvailabilityService;
        $this->classBussyCheckerService = $classBussyCheckerService;
        $this->affectationSalleService=$affectationSalleService;
    }
    // Logique principale, en utilisant les services injectés
    public function generateTimetable(Classes $classe, array $study_days, array &$schedule = [], string $semestre, array &$tour_matiere = [],$salles,$tablEdt): bool
    {
        
        $matieres = $classe->getMatieres()->toArray();
        if (empty($tour_matiere)) {
            foreach ($matieres as $index => $matiere) {
                $tour_matiere[$index] = $matiere->getVolumeHoraireRestant() ?? 0; // Assurez-vous d'initialiser avec une valeur valide
            }
        }
        for($matiere_index = 0; $matiere_index < count($matieres); $matiere_index++) {
            
            $matiere = $matieres[$matiere_index];
            if ($matiere->getSemestre() != $semestre) {
                continue;
            }
            
            if($tour_matiere[$matiere_index] >= $matiere->getVolumeHoraire()){
                continue;
            }
            foreach ($study_days as $day) {
                $slots = $this->slotService->getAvailableSlots($day);
                foreach($slots as $slot){
                    if($this->classBussyCheckerService->isClassBusy($classe->getId(), $day, $slot['heure_debut'], $slot['heure_fin'], $schedule)){
                        continue;
                    }
                    $contraintes = $matiere->getProfesseur()->getContraintes();
                    $prof = $this->profAvailabilityService->findAvailableProf($day, $slot['heure_debut'], $slot['heure_fin'], $contraintes, $schedule);
                    if($prof){
                        //$sallePrevue=$this->affectationSalleService->Affectation($salles,$classe,$tablEdt);
                       
                            $tour_matiere[$matiere_index]++;
                            $schedule[]=[
                                'classe_id' => $classe->getId(),
                                'classe' => $classe->getLibelleClasse(),
                                'matiere_id' => $matiere->getId(),
                                'matiere' => $matiere->getLibelle(),
                                'semestre'=>$matiere->getSemestre(),
                                'prof_id' => $prof->getId(),
                                'prof' => $prof->getNom(),
                                'jour' => $day,
                                'heure_debut' => $slot['heure_debut'],
                                'heure_fin' => $slot['heure_fin'],
                                //'salle'=>$sallePrevue
                            ];
                            if($this->generateTimetable($classe, $study_days, $schedule, $semestre, $tour_matiere,$salles,$tablEdt)){
                                return true;
                            }

                            array_pop($schedule);

                            if ($matiere_index >= count($matieres) - 1) {
                                return true; // Toutes les matières ont été traitées
                            }
                        
                        
                    }
                }
                
            }
        }
        return false;
    }
}
