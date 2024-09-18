<?php

namespace Src\Service;
use DateTime;

class CalculateWorkDay
{
    public function calculateHours($processedData) {
        foreach ($processedData as &$record) {
            $totalDiurnalHours = 0;
            $totalOvertimeDiurnal = 0;
            $totalOvertimeNocturnal = 0;
            $totalNocturnalSurcharge = 0;
            $totalOvertimeDiurnalHoliday = 0;
            $totalOvertimeNocturnalHoliday = 0;
            $totalNocturnalSurchargeHoliday = 0;
    
            // Iterate over each pair of in-out hours
            for ($i = 1; $i <= 3; $i++) {
                $inHour = $record["in_hour" . ($i > 1 ? "_$i" : "")];
                $outHour = $record["out_hour" . ($i > 1 ? "_$i" : "")];
    
                if ($inHour && $outHour) {
                    $inTime = new DateTime($inHour);
                    $outTime = new DateTime($outHour);
    
                    $interval = $inTime->diff($outTime);
                    $hoursWorked = $interval->h + $interval->i / 60;
    
                    // Horas diurnas (06:01 a.m. - 09:00 p.m.)
                    $diurnalHours = $this->calculateDiurnalHours($inTime, $outTime);
                    $totalDiurnalHours += $diurnalHours;
    
                    // Horas extras diurnas (si excede las 8 horas)
                    if ($totalDiurnalHours > 8) {
                        $totalOvertimeDiurnal += $totalDiurnalHours - 8;
                    }
    
                    // Horas extras nocturnas (09:00 p.m. - 06:00 a.m.)
                    $nocturnalOvertime = $this->calculateNocturnalOvertime($inTime, $outTime);
                    $totalOvertimeNocturnal += $nocturnalOvertime;
    
                    // Recargos nocturnos
                    $nocturnalSurcharge = $this->calculateNocturnalSurcharge($inTime, $outTime);
                    $totalNocturnalSurcharge += $nocturnalSurcharge;
    
                    // Si es festivo
                    if ($record['holiday']) {
                        // Horas extras diurnas festivas
                        if ($diurnalHours > 8) {
                            $totalOvertimeDiurnalHoliday += $diurnalHours - 8;
                        }
    
                        // Horas extras nocturnas festivas (00:00 a.m. - 11:59 p.m.)
                        $nocturnalOvertimeHoliday = $this->calculateNocturnalOvertimeHoliday($inTime, $outTime);
                        $totalOvertimeNocturnalHoliday += $nocturnalOvertimeHoliday;
    
                        // Recargos nocturnos festivos
                        $nocturnalSurchargeHoliday = $this->calculateNocturnalSurchargeHoliday($inTime, $outTime);
                        $totalNocturnalSurchargeHoliday += $nocturnalSurchargeHoliday;
                    }
                }
            }
    
            // Assign calculated values to the record
            $record['HD'] = $totalDiurnalHours;
            $record['H.E.D'] = $totalOvertimeDiurnal;
            $record['H.E.N'] = $totalOvertimeNocturnal;
            $record['R.N.'] = $totalNocturnalSurcharge;
            $record['H.E.D.F'] = $totalOvertimeDiurnalHoliday;
            $record['H.E.N.F'] = $totalOvertimeNocturnalHoliday;
            $record['R.N.F'] = $totalNocturnalSurchargeHoliday;
        }
    
        return $processedData;
    }
    
    private function calculateDiurnalHours($inTime, $outTime) {
        $diurnalStart = new DateTime($inTime->format('Y-m-d') . ' 06:01');
        $diurnalEnd = new DateTime($inTime->format('Y-m-d') . ' 21:00');
    
        if ($inTime < $diurnalStart) {
            $inTime = $diurnalStart;
        }
        if ($outTime > $diurnalEnd) {
            $outTime = $diurnalEnd;
        }
    
        if ($inTime < $outTime) {
            $interval = $inTime->diff($outTime);
            return $interval->h + $interval->i / 60;
        }
    
        return 0;
    }
    
    private function calculateNocturnalOvertime($inTime, $outTime) {
        $nocturnalStart = new DateTime($inTime->format('Y-m-d') . ' 21:00');
        $nocturnalEnd = new DateTime($outTime->format('Y-m-d') . ' 06:00');
        $nextDay = clone $outTime;
        $nextDay->modify('+1 day');
    
        if ($inTime > $nocturnalStart) {
            $nocturnalEnd = clone $outTime;
        } else {
            $nocturnalStart = clone $inTime;
        }
    
        if ($outTime > $nocturnalStart) {
            if ($outTime < $nocturnalEnd) {
                $interval = $nocturnalStart->diff($outTime);
            } else {
                $interval = $nocturnalStart->diff($nocturnalEnd);
            }
            return $interval->h + $interval->i / 60;
        }
    
        return 0;
    }
    
    private function calculateNocturnalSurcharge($inTime, $outTime) {
        $surchargeStart1 = new DateTime($inTime->format('Y-m-d') . ' 21:00');
        $surchargeEnd1 = new DateTime($inTime->format('Y-m-d') . ' 23:59:59');
        $surchargeStart2 = new DateTime($inTime->format('Y-m-d') . ' 00:00:01');
        $surchargeEnd2 = new DateTime($inTime->format('Y-m-d') . ' 06:00');
    
        $totalSurcharge = 0;
    
        if ($inTime < $surchargeEnd1 && $outTime > $surchargeStart1) {
            $start = max($inTime, $surchargeStart1);
            $end = min($outTime, $surchargeEnd1);
            $interval = $start->diff($end);
            $totalSurcharge += $interval->h + $interval->i / 60;
        }
    
        if ($inTime < $surchargeEnd2 && $outTime > $surchargeStart2) {
            $start = max($inTime, $surchargeStart2);
            $end = min($outTime, $surchargeEnd2);
            $interval = $start->diff($end);
            $totalSurcharge += $interval->h + $interval->i / 60;
        }
    
        return $totalSurcharge;
    }
    
    private function calculateNocturnalOvertimeHoliday($inTime, $outTime) {
        $nocturnalStart = new DateTime($inTime->format('Y-m-d') . ' 00:00');
        $nocturnalEnd = new DateTime($outTime->format('Y-m-d') . ' 23:59:59');
    
        if ($inTime < $nocturnalStart) {
            $inTime = $nocturnalStart;
        }
        if ($outTime > $nocturnalEnd) {
            $outTime = $nocturnalEnd;
        }
    
        if ($inTime < $outTime) {
            $interval = $inTime->diff($outTime);
            return $interval->h + $interval->i / 60;
        }
    
        return 0;
    }
    
    private function calculateNocturnalSurchargeHoliday($inTime, $outTime) {
        $surchargeStart1 = new DateTime($inTime->format('Y-m-d') . ' 21:00');
        $surchargeEnd1 = new DateTime($inTime->format('Y-m-d') . ' 23:59:59');
        $surchargeStart2 = new DateTime($inTime->format('Y-m-d') . ' 00:00:01');
        $surchargeEnd2 = new DateTime($inTime->format('Y-m-d') . ' 06:00');
    
        $totalSurcharge = 0;
    
        if ($inTime < $surchargeEnd1 && $outTime > $surchargeStart1) {
            $start = max($inTime, $surchargeStart1);
            $end = min($outTime, $surchargeEnd1);
            $interval = $start->diff($end);
            $totalSurcharge += $interval->h + $interval->i / 60;
        }
    
        if ($inTime < $surchargeEnd2 && $outTime > $surchargeStart2) {
            $start = max($inTime, $surchargeStart2);
            $end = min($outTime, $surchargeEnd2);
            $interval = $start->diff($end);
            $totalSurcharge += $interval->h + $interval->i / 60;
        }
    
        return $totalSurcharge;
    }
    
    // Usage
    // $processedData = calculateHours($processedData);
}