<?php

namespace App\Controller;
use App\Service\ExcelDataProcessor;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HumanResourcesController extends AbstractController
{
    private $excelProcessor;

    public function __construct(ExcelDataProcessor $excelProcessor)
    {
        $this->excelProcessor = $excelProcessor;
    }


    #[Route('/HR', name: 'app_human_resources')]
    public function index(): Response
    {
        return $this->render('human_resources/human_resource.html.twig');
    }

    #[Route('/HR/biometric', name: 'app_biometric')]
    public function getBiometric(Request $request): Response
    {
        $file = $request->files->get('excel_file');
        if($file){
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            $header =[
                'A' => 'Departamento',
                'B' => 'Colaborador',
                'C' => 'Cod. Nomina',
                'D' => 'Cedula',
                'E' => 'Fecha registro',
                'F' => 'Hora entrada',
                'G' => 'Hora salida',
                'H' => 'Hora entrada 2',
                'I' => 'Hora salida 2',
                'J' => 'Hora entrada 3',
                'K' => 'Hora salida 3',
                'L' => 'Dia',
                'M' => 'Dia Festivo',
            ];
            // Procesa los datos usando la clase separada
            $organizedData = $this->excelProcessor->processData($sheetData);

            return $this->render('human_resources/_registers.html.twig', [
                'sheetData' => $organizedData,
                'header' => $header
            ]);
        }
        return $this->render('human_resources/_registers.html.twig');
    }

    #[Route('/HR/importar-biom', name: 'app_import_biometrico', methods: ['POST'])]
    public function setBiometric(Request $request): Response
    {
        //logica para guardar los datos en la base de datos
        
        return $this->redirectToRoute('app_human_resources');
    }

    #[Route('/HR/schedule', name: 'app_schedule')]
    public function getSchedule(): Response
    {
        return $this->render('human_resources/_schedule.html.twig');
    }

    #[Route('/HR/employees', name: 'app_employees')]
    public function getEmployee(): Response
    {
        return $this->render('human_resources/_employees.html.twig');
    }

    #[Route('/HR/nomina', name: 'app_nomina')]
    public function getNomina(): Response
    {
        return $this->render('human_resources/_nomina.html.twig');
    }

    #[Route('/HR/certificate', name: 'app_certificate')]
    public function getcertificate(): Response
    {
        return $this->render('human_resources/_certificate.html.twig');
    }
}
