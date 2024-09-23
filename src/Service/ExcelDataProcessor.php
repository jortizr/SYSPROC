<?php
namespace App\Service;
use DateTime;
use App\Service\FestiveDaysChecker;
use IntlDateFormatter;

class ExcelDataProcessor
{
    private $festiveDaysChecker;

    public function __construct(FestiveDaysChecker $festiveDaysChecker)
    {
        $this->festiveDaysChecker = $festiveDaysChecker;
    }
    public function processData(array $sheetData): array
    {
        $processedData = [];
        array_shift($sheetData);
        
        foreach ($sheetData as $row) {
            // Aquí organizas los datos según los encabezados
            $name = $row['A'] ?? null;
            $cod_nomina = $row['B'];
            $cc = $row['E'];
            
            //valida si las celdas clave tienen valores null
            if(empty($name)){
                continue;
            }

            // Divide la fecha y la hora
            if($row['C'] !== null){
                list($date, $time) = explode(' ', $row['C'], 2);
            }


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
            $holiday = $this->festiveDaysChecker->isHoliday($dateFormat->format('Y-m-d'));

            $date = $dateFormat->format('Y-m-d');
            //valida que dia segun la fecha
            if($dateFormat->format('l') === 'Sunday'){
                $dayOfWeek = 'Domingo';
            }
            if ($row['D'] === 'Entrada') {
                $inHour = $date . ' ' . $time;
            } elseif ($row['D'] === 'Salida' || $row['D'] === 'Sal/T.Extra') {
                $outHour = $date . ' ' . $time;
            }
            //validar que dia de la semana es
            

            // Organiza la información para el primer registro
            $processedData[] = [
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
                'day' => $dayOfWeek,
                'holiday' => $holiday,
            ];

        }
            $processedData = $this->sortDataByDateAndName($processedData);
            $combinateData =$this->mergeEntries($processedData);
            // Aquí podrías realizar el paso 2, uniendo los registros según sea necesario
        return $combinateData;
    }

    private function mergeEntries(array $data): array
    {
        $mergedData = [];
        foreach ($data as $entry) {
            $key = $entry['name'] . '_' . $entry['date'];
    
            if (!isset($mergedData[$key])) {
                // Si no existe, lo agregamos al array
                $mergedData[$key] = $entry;
            } else {
                // Si ya existe, fusionamos las horas
                if (!is_null($entry['in_hour'])) {
                    if (is_null($mergedData[$key]['in_hour'])) {
                        $mergedData[$key]['in_hour'] = $entry['in_hour'];
                    } elseif (is_null($mergedData[$key]['in_hour_2'])) {
                        $mergedData[$key]['in_hour_2'] = $entry['in_hour'];
                    } elseif (is_null($mergedData[$key]['in_hour_3'])) {
                        $mergedData[$key]['in_hour_3'] = $entry['in_hour'];
                    }
                }
    
                if (!is_null($entry['out_hour'])) {
                    if (is_null($mergedData[$key]['out_hour'])) {
                        $mergedData[$key]['out_hour'] = $entry['out_hour'];
                    } elseif (is_null($mergedData[$key]['out_hour_2'])) {
                        $mergedData[$key]['out_hour_2'] = $entry['out_hour'];
                    } elseif (is_null($mergedData[$key]['out_hour_3'])) {
                        $mergedData[$key]['out_hour_3'] = $entry['out_hour'];
                    }
                }
            }
        }
        return array_values($mergedData); // Retorna el array fusionado sin claves asociativas
}

    private function sortDataByDateAndName(array $processedData): array {
        usort($processedData, function ($a, $b) {
                    // Comparar por fecha
                    $dateComparison = strcmp($a['name'], $b['name']);
                    
                    // Si las fechas son iguales, comparar por nombre
                    if ($dateComparison === 0) {
                        return strcmp($a['date'], $b['date']);
                    }
                
                    // Si las fechas son diferentes, devolver el resultado de la comparación por fecha
                    return $dateComparison;
                });

        return $processedData;
    }
    //funcion para obtener el dia de la semana en español
    public function getDayOfWeekInSpanish($date) {
        // Crear un formateador de fecha en español
        $formatter = new IntlDateFormatter(
            'es_ES', // Locale en español
            IntlDateFormatter::FULL, // Formato completo
            IntlDateFormatter::NONE, // No se necesita formato para la hora
            null, // Usar el formato por defecto
            null, // Usar el formato por defecto
            'eeee' // Formato para el nombre completo del día
        );
    
        // Formatear la fecha para obtener el nombre del día de la semana en español
        return $formatter->format($date);
    }
}
