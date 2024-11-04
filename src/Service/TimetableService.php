<?php

namespace App\Service;

use App\Entity\Professeurs;

class TimetableService
{
    // Fonction principale de génération d'emploi du temps avec backtracking
    public function generateTimetable(array $classes, array $profs_availabilities, array $study_days, array &$schedule = [], int $class_index = 0): bool
    {
        if ($class_index >= count($classes)) {
            return true;
        }

        $class = $classes[$class_index];

        foreach ($class->getMatieres() as $matiere) {
            foreach ($study_days as $day) {
                $available_slots = $this->getAvailableSlots($day);

                foreach ($available_slots as $slot) {
                    $prof = $this->findAvailableProf($matiere->getId(), $day, $slot['heure_debut'], $slot['heure_fin'], $profs_availabilities, $schedule);

                    if ($prof) {
                        $schedule[] = [
                            'classe_id' => $class->getId(),
                            'matiere_id' => $matiere->getId(),
                            'prof_id' => $prof->getId(),
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

    public function findAvailableProf(int $matiere_id, string $day, string $heure_debut, string $heure_fin, array $profs_availabilities, array $schedule): ?Professeurs
    {
        foreach ($profs_availabilities as $prof) {
            if (in_array($matiere_id, $prof->getMatieres()->toArray())) {
                foreach ($prof->getDisponibilites() as $disponibilite) {
                    if ($disponibilite->getJour()->format('Y-m-d') == $day &&
                        $disponibilite->getHeureDebut() <= $heure_debut &&
                        $disponibilite->getHeureFin() >= $heure_fin) {

                        if (!$this->isProfBusy($prof->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                            return $prof;
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
