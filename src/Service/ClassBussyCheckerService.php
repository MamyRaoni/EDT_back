<?php
namespace App\Service;

class ClassBussyCheckerService
{
    public function isClassBusy(int $classe_id, string $day, string $heure_debut, string $heure_fin, array $schedule): bool
    {
        foreach ($schedule as $entry) {
            if ($entry['classe_id'] === $classe_id && $entry['jour'] === $day) {
                if (($heure_debut < $entry['heure_fin'] && $heure_debut >= $entry['heure_debut']) ||
                    ($heure_fin > $entry['heure_debut'] && $heure_fin <= $entry['heure_fin'])) {
                    return true;
                }
            }
        }
        return false;
    }
}
