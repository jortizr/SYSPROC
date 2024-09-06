<?php
namespace App\Service;

class ExcelDataProcessor{
    public function processData(array $sheetData): array
    {
        $processedData = [];

        foreach ($sheetData as $row) {
            // Aquí organizas los datos según los encabezados
            $company = $row['A'];
            $name = $row['B'];
            $cod_nomina = $row['C'];
            $cc = $row['F'];
            
            // Divide la fecha y la hora
            list($date, $time) = explode(' ', $row['D'], 2);
            
            // Dependiendo del estado (E), se asigna la hora
            $inHour = null;
            $outHour = null;
            if ($row['E'] === 'Entrada') {
                $inHour = $time;
            } elseif ($row['E'] === 'Salida') {
                $outHour = $time;
            }
            
            // Organiza la información para el primer registro
            $processedData[] = [
                'company' => $company,
                'name' => $name,
                'cod_nomina' => $cod_nomina,
                'cc' => $cc,
                'date' => $date,
                'in_hour' => $inHour,
                'out_hour' => $outHour,
            ];
        }

        // Aquí podrías realizar el paso 2, uniendo los registros según sea necesario
        return $this->mergeEntries($processedData);
    }

    private function mergeEntries(array $data): array
    {
        $mergedData = [];

        foreach ($data as $entry) {
            // Lógica para fusionar registros con el mismo nombre, fecha, etc.
            $key = $entry['name'] . $entry['date'];
            
            if (!isset($mergedData[$key])) {
                // Si no existe, lo agregamos al array
                $mergedData[$key] = $entry;
            } else {
                // Si ya existe, unimos las horas de entrada y salida
                $existingEntry = &$mergedData[$key];

                if ($entry['in_hour']) {
                    if (is_null($existingEntry['in_hour'])) {
                        $existingEntry['in_hour'] = $entry['in_hour'];
                    } 
                    elseif (is_null($existingEntry['in_hour_2'])) {
                        $existingEntry['in_hour_2'] = $entry['in_hour'];
                    }
                    elseif (is_null($existingEntry['in_hour_3'])) {
                        $existingEntry['in_hour_3'] = $entry['in_hour'];
                    }
                }

                if ($entry['out_hour']) {
                    if (is_null($existingEntry['out_hour'])) {
                        $existingEntry['out_hour'] = $entry['out_hour'];
                    } 
                    elseif (is_null($existingEntry['out_hour_2'])) {
                        $existingEntry['out_hour_2'] = $entry['out_hour'];
                    }
                    elseif (is_null($existingEntry['out_hour_3'])) {
                        $existingEntry['out_hour_3'] = $entry['out_hour'];
                    }
                }
            }
        }

        return array_values($mergedData); // Retorna el array fusionado sin claves
    }
}
