<?php

namespace App\Service;

use App\Entity\Professeurs;

class TimetableService
{
    // Fonction principale de génération d'emploi du temps avec backtracking
    // public function generateTimetable($classes, array $profs_availabilities, array $study_days, array &$schedule = []): bool
    // {
    //     // if ($class_index >= count($classes)) {
    //     //     return true;
    //     // }

    //     // $class = $classes[$class_index];
        



        
    //     // foreach($classes->getMatieres()->toArray() as $matiere){
    //     //     //dump($matiere);
    //     //     foreach($study_days as $day){
    //     //         $available_slots=$this->getAvailableSlots($day);
    //     //         dump($available_slots);

    //     //     }
    //     // }
        

    //     foreach ($classes->getMatieres()->toArray() as $matiere) {
    //         //dump($matiere);
    //         foreach ($study_days as $day) {
    //             $available_slots = $this->getAvailableSlots($day);
    //             //dump($day);
    //             foreach ($available_slots as $index=>$slot) {
    //                 dump($index);
    //                 dump($slot);
    //                 $prof = $this->findAvailableProf($day, $slot['heure_debut'], $slot['heure_fin'], $profs_availabilities, $schedule);

    //                 if ($prof) {
    //                     $schedule[] = [
    //                         'classe_id' => $classes->getId(),
    //                         'matiere_id' => $matiere->getId(),
    //                         'prof_id' => $prof->getId(),
    //                         'jour' => $day,
    //                         'heure_debut' => $slot['heure_debut'],
    //                         'heure_fin' => $slot['heure_fin']
    //                     ];

    //                     if ($this->generateTimetable($classes, $profs_availabilities, $study_days, $schedule)) {
    //                         return true;
    //                     }

    //                     array_pop($schedule);
    //                 }
    //             }
    //         }
    //     }

    //     return false;
    // }

    // public function findAvailableProf( string $day, string $heure_debut, string $heure_fin, array $profs_availabilities, array $schedule): ?Professeurs
    // {
    //     foreach ($profs_availabilities as $contrainte) {
    //             foreach ($contrainte->getDisponibilite() as $disponibilite) {
    //                 dump($disponibilite);
    //                 if ($disponibilite) {
    //                     dump($contrainte->getProfesseur());
    //                     if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
    //                         return $contrainte->getProfesseur();
    //                     }
    //                 }
    //             }
            
    //     }

    //     return null;
    // }
    public function generateTimetable($classe, array $study_days, array &$schedule = []): bool
{
    
    dump("debut de generatetimetable");
    
    $matieres = $classe->getMatieres()->toArray();
    //dump($matieres);
    
    // Ajout de l'index pour les matières
    for ($matiere_index = 0; $matiere_index < count($matieres); $matiere_index++) {
        
        $matiere = $matieres[$matiere_index];
        dump("Traitement de la matière : " . $matiere->getLibelle());
        // if(!empty($schedule)){
        //     foreach($schedule as $edt){
        //         if($edt["matiere"]==$matiere->getLibelle()){
                    
        //         }
        //     }
        //     continue;
        // }
        $foundSlot = false;
        foreach ($study_days as $day) {
            dump("le jour de : ".$day);
            foreach ($this->getAvailableSlots($day) as $slot) {
                dump("le slot d'heure : ");
                dump($slot);
                if ($this->isClassBusy($classe->getId(), $day, $slot['heure_debut'], $slot['heure_fin'], $schedule)) {
                    continue; // Passer au créneau suivant si la classe est occupée
                }
                $contraintes = $matiere->getProfesseur()->getContraintes();
                $prof = $this->findAvailableProf($day, $slot['heure_debut'], $slot['heure_fin'], $contraintes, $schedule, $slot);
                
                if ($prof) {
                    dump("le prof selectionne : ".$prof->getNom());
                    $schedule[] = [
                        'classe_id' => $classe->getId(),
                        'classe' => $classe->getLibelleClasse(),
                        'matiere_id' => $matiere->getId(),
                        'matiere' => $matiere->getLibelle(),
                        'prof_id' => $prof->getId(),
                        'prof' => $prof->getNom(),
                        'jour' => $day,
                        'heure_debut' => $slot['heure_debut'],
                        'heure_fin' => $slot['heure_fin']
                    ];
                    
                    //dump($schedule);
                    // Condition de terminaison pour les matières
                    if ($matiere_index >= count($matieres) - 1) {
                        return true; // Toutes les matières ont été traitées
                    }
                    
                    if ($this->generateTimetable($classe, $study_days, $schedule)) {
                        return true;
                    }
                    array_pop($schedule);
                }
            }
        }
    }
    return false;
}
    public function isClassBusy(int $classe_id, string $day, string $heure_debut, string $heure_fin, array $schedule): bool
        {
            foreach ($schedule as $entry) {
                if ($entry['classe_id'] == $classe_id && $entry['jour'] == $day) {
                    if (($heure_debut < $entry['heure_fin'] && $heure_debut >= $entry['heure_debut']) ||
                        ($heure_fin > $entry['heure_debut'] && $heure_fin <= $entry['heure_fin'])) {
                        return true; // La classe est déjà occupée à ce créneau
                    }
                }
            }
            return false;
        }

    public function findAvailableProf(string $day, string $heure_debut, string $heure_fin, $contraintes, array $schedule): ?Professeurs
    {
        foreach ($contraintes as $contrainte) {
            if($day==$contrainte->getJour()->format('Y-m-d')){
                //hamaky anle disponibilite amzay
               foreach($contrainte->getDisponibilite() as $index=>$booleen){
                    if($booleen){
                        switch ($index) {
                            case 0:
                                if($heure_debut=="07:30"&& $heure_fin == "09:00"){
                                    dump("tafiditra ato 7h30");
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 1:
                                
                                if($heure_debut == "09:00"&& $heure_fin == "10:30"){
                                    dump("tafiditra ato 9h");
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 2:
                                if($heure_debut == "10:30" && $heure_fin == "12:00"){
                                    dump("tafiditra ato 10h30");
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 3:
                                if($heure_debut == "13:30" && $heure_fin == "15:00"){
                                    dump("tafiditra ato 13h30");
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 4:
                                if($heure_debut == "15:00" && $heure_fin == "16:30"){
                                    dump("tafiditra ato 15h");
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 5:
                                if($heure_debut == "16:30" && $heure_fin == "18:00"){
                                    dump("tafiditra ato 16h30");
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                        }
                      }
                 }
            }
        }
        return null;
    }

    public function isProfBusy(int $prof_id, string $day, string $heure_debut, string $heure_fin, array $schedule): bool
    {
        //tokony eto nou miverifier anle schedule avy any amin'ny base 
        dump($schedule);
        foreach ($schedule as $entry) {
                // dump("entry");
                // dump($entry2['prof_id'], $prof_id);
                // dd($entry2);
                
                //dump($entry);
                if ($entry['prof_id'] == $prof_id && $entry['jour'] == $day) {
                    if (($heure_debut < $entry['heure_fin'] && $heure_debut >= $entry['heure_debut']) ||
                        ($heure_fin > $entry['heure_debut'] && $heure_fin <= $entry['heure_fin'])) {
                        return true;
                    }
                }
                
            
        }
        return false;
    }

    public function getAvailableSlots(string $day): array
    {
        $start_time = "07:30";
        $end_time = "18:00";
        $slot_duration = 3/2 * 60;

        $start_minutes = $this->timeToMinutes($start_time);
        $end_minutes = $this->timeToMinutes($end_time);

        $available_slots = [];

        for ($current_time = $start_minutes; $current_time + $slot_duration <= $end_minutes; $current_time += $slot_duration) {
            $slot_start = $this->minutesToTime($current_time);
            $slot_end = $this->minutesToTime($current_time + $slot_duration);
            $available_slots[] = [
                'jour' => $day,
                'heure_debut' => $slot_start,
                'heure_fin' => $slot_end
            ];
        }

        return $available_slots;
    }

    public function timeToMinutes(string $time): int
    {
        list($hours, $minutes) = explode(':', $time);
        return $hours * 60 + $minutes;
    }

    public function minutesToTime(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }
}