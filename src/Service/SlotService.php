<?php

namespace App\Service;

class SlotService
{
    public function getAvailableSlots(string $day): array
    {
        $start_time = "07:30";
        $end_time = "18:00";
        $slot_duration = 90; // Durée des créneaux en minutes (1,5 heures)

        $start_minutes = $this->timeToMinutes($start_time);
        $end_minutes = $this->timeToMinutes($end_time);

        $available_slots = [];
        for ($current_time = $start_minutes; $current_time + $slot_duration <= $end_minutes; $current_time += $slot_duration) {
            $available_slots[] = [
                'jour' => $day,
                'heure_debut' => $this->minutesToTime($current_time),
                'heure_fin' => $this->minutesToTime($current_time + $slot_duration)
            ];
        }
        return $available_slots;
    }

    private function timeToMinutes(string $time): int
    {
        list($hours, $minutes) = explode(':', $time);
        return $hours * 60 + $minutes;
    }

    private function minutesToTime(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }
}
