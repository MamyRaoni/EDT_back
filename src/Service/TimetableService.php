<?php

namespace App\Service;

class TimetableService
{
    // Fonction principale de génération d'emploi du temps avec backtracking
    public function generateTimetable($classes, $profs_availabilities, $study_days, &$schedule = [], $class_index = 0)
    {
        if ($class_index >= count($classes)) {
            return true;
        }

        $class = $classes[$class_index];

        foreach ($class['matieres'] as $matiere) {
            foreach ($study_days as $day) {
                $available_slots = $this->getAvailableSlots($day);

                foreach ($available_slots as $slot) {
                    $prof = $this->findAvailableProf($matiere['id'], $day, $slot['heure_debut'], $slot['heure_fin'], $profs_availabilities, $schedule);

                    if ($prof) {
                        $schedule[] = [
                            'classe_id' => $class['id'],
                            'matiere_id' => $matiere['id'],
                            'prof_id' => $prof['id'],
                            'jour' => $day,
                            'heure_debut' => $slot['heure_debut'],
                            'heure_fin' => $slot['heure_fin']
                        ];

                        if ($this->generateTimetable($classes, $profs_availabilities, $study_days, $schedule, $class_index + 1)) {
                            return true;
                        }

                        array_pop($schedule);
                    }
                }
            }
        }

        return false;
    }

    // Fonction pour trouver un professeur disponible
    public function findAvailableProf($matiere_id, $day, $heure_debut, $heure_fin, $profs_availabilities, $schedule)
    {
        foreach ($profs_availabilities as $prof) {
            if (in_array($matiere_id, $prof['matieres'])) {
                foreach ($prof['disponibilites'] as $disponibilite) {
                    if ($disponibilite['jour'] == $day &&
                        $disponibilite['heure_debut'] <= $heure_debut &&
                        $disponibilite['heure_fin'] >= $heure_fin) {

                        if (!$this->isProfBusy($prof['id'], $day, $heure_debut, $heure_fin, $schedule)) {
                            return $prof;
                        }
                    }
                }
            }
        }

        return null;
    }

    // Vérifier si un professeur est occupé
    public function isProfBusy($prof_id, $day, $heure_debut, $heure_fin, $schedule)
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

    // Fonction pour générer les créneaux horaires disponibles
    public function getAvailableSlots($day)
    {
        $start_time = "08:00";
        $end_time = "18:00";
        $slot_duration = 2 * 60;

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

    // Convertir heure en minutes
    public function timeToMinutes($time)
    {
        list($hours, $minutes) = explode(':', $time);
        return $hours * 60 + $minutes;
    }

    // Convertir minutes en heure
    public function minutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }
}
