<?php

namespace App\Controller;
use App\Service\ExcelDataProcessor;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Biometric;
use App\Service\CalculateWorkDay;




class HumanResourcesController extends AbstractController
{
    private $excelProcessor;
    private $calculateWorkDay;

    public function __construct(ExcelDataProcessor $excelProcessor, CalculateWorkDay $calculateWorkDay)
    {   
        $this->excelProcessor = $excelProcessor;
        $this->calculateWorkDay = $calculateWorkDay;
    }

  
    #[Route('/HR', name: 'app_human_resources')]

    public function index(): Response
    {
        return $this->render('human_resources/human_resource.html.twig');
    }

    #[Route('/HR/biometric', name: 'app_biometric')]
    public function getBiometric(Request $request, SessionInterface $session): Response
    {
        try{
        $file = $request->files->get('excel_file');

        if ($file && $file->getClientOriginalExtension() !== 'xlsx') {
            throw new \Exception('El archivo adjuntado no tiene la extension .xlsx.');
        }

        if($file){
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

             // Obtener los encabezados del archivo (primera fila del array sheetData)
            $fileHeaders = array_values($sheetData[1]);  // Convierte los encabezados a un array de valores
            //  Encabezados esperados
            $expectedHeaders = ['Departamento', 'Nombre y Apellido', 'No.ID', 'Fecha/Hora', 'Estado', 'No.Cédula'];

            // Comparar los encabezados
            if ($fileHeaders !== $expectedHeaders) {
                throw new \Exception('El archivo excel no tiene el formato correcto. Para mas info, Clic en el icono de ayuda');
            }
            $header =[
                'Departamento',
                'Colaborador',
                'Cod. Nomina',
                'Cedula',
                'Fecha registro (yyyy/mm/dd)',
                'Hora entrada',
                'Hora salida',
                'Hora entrada 2',
                'Hora salida 2',
                'Hora entrada 3',
                'Hora salida 3',
                'Dia',
                'Dia Festivo',
                // 'HD',
                // 'H.E.D', 
                // 'H.E.N', 
                // 'R.N.', 
                // 'H.E.D.F', 
                // 'H.E.N.F', 
                // 'R.N.F'
            ];
            
            // Procesa los datos usando la clase separada
            $organizedData = $this->excelProcessor->processData($sheetData);
            //evaluar si es un dia festivo


            // Guardar los datos en la sesión para subirlos a la base de datos en otra ruta
            $session->set('sheetData', $organizedData);

            return $this->render('human_resources/_registers.html.twig', [
                'sheetData' => $organizedData,
                'header' => $header,
            ]);
        }
        return $this->render('human_resources/_registers.html.twig');
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_biometric');
        }
    }

    #[Route('/HR/importar-biom', name: 'app_import_biometrico', methods: ['POST'])]
    public function setBiometric(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sheetData = $request->getSession()->get('sheetData'); // Obtener los datos de la sesión

        if ($sheetData) {
            foreach ($sheetData as $data) {
                $biometrico = new Biometric();
                $biometrico->setCompany($data['company']);
                $biometrico->setName($data['name']);
                $biometrico->setCodNomina($data['cod_nomina']);
                $biometrico->setCc($data['cc']);
                $biometrico->setDate(new \DateTimeImmutable($data['date']));
                // Validar si los campos de hora tienen valor, si no, asignar null
                $biometrico->setInHour(!empty($data['in_hour']) ? new \DateTimeImmutable($data['in_hour']) : null);
                $biometrico->setOutHour(!empty($data['out_hour']) ? new \DateTimeImmutable($data['out_hour']) : null);
                $biometrico->setInHour2(!empty($data['in_hour_2']) ? new \DateTimeImmutable($data['in_hour_2']) : null);
                $biometrico->setOutHour2(!empty($data['out_hour_2']) ? new \DateTimeImmutable($data['out_hour_2']) : null);
                $biometrico->setInHour3(!empty($data['in_hour_3']) ? new \DateTimeImmutable($data['in_hour_3']) : null);
                $biometrico->setOutHour3(!empty($data['out_hour_3']) ? new \DateTimeImmutable($data['out_hour_3']) : null);
 
                $biometrico->setHoliday($data['holiday']);
                $entityManager->persist($biometrico); // Preparar los datos para ser guardados en la base de datos
            }
            $entityManager->flush(); // Guardar los cambios en la base de datos
            
            // Limpiar los datos de la sesión
            $this->addFlash('success', 'Los datos se han guardado satisfactoriamente.');
            $request->getSession()->remove('sheetData');
            return $this->redirectToRoute('app_biometric');
        }
        return $this->render('human_resources/human_resource.html.twig');
    }

    #[Route('/HR/new-schedule', name: 'app_schedule')]
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
