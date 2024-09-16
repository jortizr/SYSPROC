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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;



class HumanResourcesController extends AbstractController
{
    private $excelProcessor;
    private $security;

    public function __construct(ExcelDataProcessor $excelProcessor, Security $security)
    {   
        $this->security = $security;
        $this->excelProcessor = $excelProcessor;
    }

  
    #[Route('/HR', name: 'app_human_resources')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        // Obtener el usuario logueado
        $user = $this->security->getUser();

        // Obtener los datos del usuario

        return $this->render('human_resources/human_resource.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/HR/biometric', name: 'app_biometric')]
    public function getBiometric(Request $request, SessionInterface $session): Response
    {
        try{
        $file = $request->files->get('excel_file');

        if ($file && $file->getClientOriginalExtension() !== 'xlsx') {
            throw new \Exception('El archivo adjuntado no tiene la extensión .xlsx.');
        }

        if($file){
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $header =[
                'A' => 'Departamento',
                'B' => 'Colaborador',
                'C' => 'Cod. Nomina',
                'D' => 'Cedula',
                'E' => 'Fecha registro (yyyy/mm/dd)',
                'F' => 'Hora entrada',
                'G' => 'Hora salida',
                'H' => 'Hora entrada 2',
                'I' => 'Hora salida 2',
                'J' => 'Hora entrada 3',
                'K' => 'Hora salida 3',
                'L' => 'Dia',
                'M' => 'Dia Festivo',
            ];
            //  Encabezados esperados
             $expectedHeaders = ['Departamento', 'Nombre y Apellido', 'No.ID', 'Fecha/Hora', 'Estado', 'No.Cédula'];
             // Obtener los encabezados del archivo (primera fila del array sheetData)
            $fileHeaders = array_values($sheetData[1]);  // Convierte los encabezados a un array de valores
            // Comparar los encabezados
            if ($fileHeaders !== $expectedHeaders) {
                throw new \Exception('El archivo excel no tiene el formato correcto. Verifica el archivo y vuelve a intentarlo.');
            }
            
            // Procesa los datos usando la clase separada
            $organizedData = $this->excelProcessor->processData($sheetData);
            // Guardar los datos en la sesión para subirlos a la base de datos en otra ruta
            $session->set('sheetData', $organizedData);

            return $this->render('human_resources/_registers.html.twig', [
                'sheetData' => $organizedData,
                'header' => $header
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
                $biometrico->setInHour(new \DateTimeImmutable($data['in_hour']));
                $biometrico->setOutHour(new \DateTimeImmutable($data['out_hour']));
                $biometrico->setInHour2(new \DateTimeImmutable($data['in_hour_2']));
                $biometrico->setOutHour2(new \DateTimeImmutable($data['out_hour_2']));
                $biometrico->setInHour3(new \DateTimeImmutable($data['in_hour_3']));
                $biometrico->setOutHour3(new \DateTimeImmutable($data['out_hour_3']));
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
