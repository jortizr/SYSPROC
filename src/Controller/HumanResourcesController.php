<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HumanResourcesController extends AbstractController
{
    #[Route('/HR', name: 'app_human_resources')]
    public function index(): Response
    {
        return $this->render('human_resources/human_resource.html.twig');
    }

    #[Route('/HR/biometric', name: 'app_biometric')]
    public function getBiometric(): Response
    {
        // $file = $request->files->get('excel_file');
        // if($file){
        //     $spreadsheet = IOFactory::load($file->getPathname());
        //     $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        //     return $this->render('human_resources/_registros.html.twig', [
        //         'sheetData' => $sheetData
        //     ]);
        // }
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
