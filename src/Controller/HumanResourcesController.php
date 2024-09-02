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

    #[Route('/HR/registros-biom', name: 'app_biometrico')]
    public function biometrico(Request $request): Response
    {
        $file = $request->files->get('excel_file');
        if($file){
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            return $this->render('human_resources/_registros.html.twig', [
                'sheetData' => $sheetData
            ]);
        }
        return $this->redirectToRoute('app_human_resources');
    }

    #[Route('/HR/importar-biom', name: 'app_import_biometrico', methods: ['POST'])]
    public function importBiometrico(Request $request): Response
    {
        //logica para guardar los datos en la base de datos
        
        return $this->redirectToRoute('app_human_resources');
    }
}
