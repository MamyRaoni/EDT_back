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
    public function generateTimetable($classes, array $study_days, array &$schedule = []): bool
    {
        dump("debut de generatetimetable");
        foreach ($classes->getMatieres()->toArray() as $matiere) {
            dump("Traitement de la matière : " . $matiere->getLibelle());
            foreach ($study_days as $day) {
                dump("". $day ."");
                foreach ($this->getAvailableSlots($day) as $index=>$slot) {
                    dump($slot);
                    $contraintes=$matiere->getProfesseur()->getContraintes();
                    $prof = $this->findAvailableProf($day, $slot['heure_debut'], $slot['heure_fin'], $contraintes, $schedule, $slot,$matiere);
                    //dump($day, $slot);
                    if ($prof) {
                        $schedule[] = [
                            'classe_id' => $classes->getId(),
                            'matiere_id' => $matiere->getId(),
                            'prof_id' => $prof->getId(),
                            'jour' => $day,
                            'heure_debut' => $slot['heure_debut'],
                            'heure_fin' => $slot['heure_fin']
                        ];
                        dump($schedule);
                        if ($this->generateTimetable($classes, $study_days, $schedule)) {
                            return true;
                        }
                        array_pop($schedule);
                    }
                }
                dump($schedule);
            }
        }
        return false;
    }

    public function findAvailableProf(string $day, string $heure_debut, string $heure_fin, $contraintes, array $schedule, array $slot, $matiere): ?Professeurs
    {
        foreach ($contraintes as $contrainte) {
            if($day==$contrainte->getJour()->format('Y-m-d')){
                //hamaky anle disponibilite amzay
                //dd($heure_debut, $heure_fin); 
                foreach($contrainte->getDisponibilite() as $index=>$booleen){
                    if($booleen){
                        switch ($index) {
                            case 0:
                                if($heure_debut=="07:30"&& $heure_fin == "09:00"){
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 1:
                                if($heure_debut == "09:00"&& $heure_fin == "10:30"){
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 2:
                                if($heure_debut == "10:30" && $heure_fin == "12:00"){
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 3:
                                if($heure_debut == "13:30" && $heure_fin == "15:00"){
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 4:
                                if($heure_debut == "15:00" && $heure_fin == "16:30"){
                                    if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                                        return $contrainte->getProfesseur();
                                    }
                                }
                                break;
                            case 5:
                                if($heure_debut == "16:30" && $heure_fin == "18:00"){
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
        foreach ($schedule as $entry) {
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