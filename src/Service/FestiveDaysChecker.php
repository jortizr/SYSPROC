<?php
namespace App\Service;
use DateTime;

class FestiveDaysChecker
{
    public function getHolidaysForYear(int $year): array
    {
        // Días festivos fijos
        $fixedHolidays = [
            "$year-01-01", // Año Nuevo
            "$year-05-01", // Día del Trabajo
            "$year-07-20", // Día de la Independencia
            "$year-08-07", // Batalla de Boyacá
            "$year-12-08", // Inmaculada Concepción
            "$year-12-25", // Navidad
        ];

        // Cálculo de festivos móviles
        $movableHolidays = $this->getMovableHolidays($year);
        //dias trasladados al lunes si caen un dia diferente a lunes
        $mondayHolidays = $this->getMondayHolidays($year);

        // Combinar festivos fijos y móviles
        return array_merge($fixedHolidays, $movableHolidays, $mondayHolidays);
    }

    // Obtener todos los días festivos en formato de string legible
    public function getHolidayListForYear(int $year = null): array
    {
        $holidays = $this->getHolidaysForYear($year);
        $formattedHolidays = [];

        foreach ($holidays as $holiday) {
            $date = new DateTime($holiday);
            // Formato legible, ejemplo: Lunes 1 de Enero
            $formattedHolidays[] = $date->format('l j \d\e F');
        }

        return $formattedHolidays;
    }

    private function getMovableHolidays(int $year): array
    {
        // Cálculo de la Pascua
        $easterDate = DateTime::createFromFormat('Y-m-d', $this->calculateEaster($year));

        // Jueves Santo (Pascua - 3 días)
        $maundyThursday = (clone $easterDate)->modify('-3 days')->format('Y-m-d');
        // Viernes Santo (Pascua - 2 días)
        $goodFriday = (clone $easterDate)->modify('-2 days')->format('Y-m-d');
        // Ascensión (Pascua + 43 días)
        $ascension = (clone $easterDate)->modify('+43 days')->format('Y-m-d');
        // Corpus Christi (Pascua + 64 días)
        $corpusChristi = (clone $easterDate)->modify('+64 days')->format('Y-m-d');
        // Sagrado Corazón (Pascua + 71 días)
        $sacredHeart = (clone $easterDate)->modify('+71 days')->format('Y-m-d');


        return [
            $maundyThursday,  // Jueves Santo
            $goodFriday,      // Viernes Santo
            $ascension,       // Ascensión
            $corpusChristi,   // Corpus Christi
            $sacredHeart,     // Sagrado Corazón
        ];
    }

    private function getMondayHolidays(int $year): array{
        //fechas que se mueven al lunes si no cen el lunes
        $holidays =[
            "$year-01-06", // Epifanía (Reyes Magos)
            "$year-03-19", // Día de San José
            "$year-06-29", // San Pedro y San Pablo
            "$year-08-15", // Asunción de la Virgen
            "$year-10-12", // Día de la Raza
            "$year-11-01", // Todos los Santos
            "$year-11-11", // Independencia de Cartagena
        ];

        //mover el lunes si no caen en lunes
        $mondayHolidays = [];
        foreach($holidays as $holiday){
            $date = new DateTime($holiday);
            if($date->format('N') !== '1'){
                $date->modify('next monday');
            }
            $mondayHolidays[] = $date->format('Y-m-d');
        }

        return $mondayHolidays;
    }

    // Algoritmo de cálculo de la fecha de Pascua (Easter)
    private function calculateEaster(int $year): string
    {
        $a = $year % 19;
        $b = intdiv($year, 100);
        $c = $year % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = ($h + $l - 7 * $m + 114) % 31 + 1;

        return sprintf('%04d-%02d-%02d', $year, $month, $day);
    }

    public function isHoliday(string $date): bool
    {
        $dateTime = new DateTime($date);
        $year = (int)$dateTime->format('Y');
        $holidays = $this->getHolidaysForYear($year);

        return in_array($dateTime->format('Y-m-d'), $holidays);
    }
}