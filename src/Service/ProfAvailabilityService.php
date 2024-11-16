<?php

namespace App\Service;

use App\Entity\Professeurs;

class ProfAvailabilityService
{
    public function findAvailableProf(string $day, string $heure_debut, string $heure_fin, $contraintes, array $schedule): ?Professeurs
    {
        foreach ($contraintes as $contrainte) {
            if ($day === $contrainte->getJour()->format('Y-m-d')) {
                foreach ($contrainte->getDisponibilite() as $index => $booleen) {
                    if ($booleen && $this->isMatchingSlot($index, $heure_debut, $heure_fin)) {
                        if (!$this->isProfBusy($contrainte->getProfesseur()->getId(), $day, $heure_debut, $heure_fin, $schedule)) {
                            return $contrainte->getProfesseur();
                        }
                    }
                }
            }
        }
        return null;
    }

    private function isMatchingSlot(int $index, string $heure_debut, string $heure_fin): bool
    {
        $slots = [
            ["07:30", "09:00"],
            ["09:00", "10:30"],
            ["10:30", "12:00"],
            ["13:30", "15:00"],
            ["15:00", "16:30"],
            ["16:30", "18:00"],
        ];
        return isset($slots[$index]) && $slots[$index] === [$heure_debut, $heure_fin];
    }

    private function isProfBusy(int $prof_id, string $day, string $heure_debut, string $heure_fin, array $schedule): bool
    {
        foreach ($schedule as $entry) {
            if ($entry['prof_id'] === $prof_id && $entry['jour'] === $day) {
                if (($heure_debut < $entry['heure_fin'] && $heure_debut >= $entry['heure_debut']) ||
                    ($heure_fin > $entry['heure_debut'] && $heure_fin <= $entry['heure_fin'])) {
                    return true;
                }
            }
        }
        return false;
    }
}
