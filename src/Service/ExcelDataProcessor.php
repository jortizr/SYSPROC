<?php
namespace App\Service;

use DateTime;
use Rmunate\Calendar\Colombia;

class ExcelDataProcessor
{
    public function processData(array $sheetData): array
    {
        $processedData = [];
        array_shift($sheetData);

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
            $inHour2 = null;
            $outHour2 = null;
            $inHour3 = null;
            $outHour3 = null;
            $outHour3 = null;
            $dayOfWeek = null;
            $holiday = null;

            //validar si es un dia festivo
            $dateFormat = DateTime::createFromFormat('d/m/Y', $date);
            $resultDate = $dateFormat->format('Y-m-d');
            

            $dayOfWeek= date('l', strtotime($date));


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
                'in_hour_2' => $inHour2,
                'out_hour_2' => $outHour2,
                'in_hour_3' => $inHour3,
                'out_hour_3' => $outHour3,
                'day' => $$dayOfWeek,
                'holiday' => $holiday,
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
                    } elseif (is_null($existingEntry['in_hour_2'])) {
                        $existingEntry['in_hour_2'] = $entry['in_hour'];
                    } elseif (is_null($existingEntry['in_hour_3'])) {
                        $existingEntry['in_hour_3'] = $entry['in_hour'];
                    }
                }

                if ($entry['out_hour']) {
                    if (is_null($existingEntry['out_hour'])) {
                        $existingEntry['out_hour'] = $entry['out_hour'];
                    } elseif (is_null($existingEntry['out_hour_2'])) {
                        $existingEntry['out_hour_2'] = $entry['out_hour'];
                    } elseif (is_null($existingEntry['out_hour_3'])) {
                        $existingEntry['out_hour_3'] = $entry['out_hour'];
                    }
                }
            }
        }

        return array_values($mergedData); // Retorna el array fusionado sin claves
    }
}
