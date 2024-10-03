<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ScheduleType;

class ScheduleController extends AbstractController
{
    #[Route('/HR/schedule', name: 'app_schedule')]
    public function schedule(EntityManagerInterface $entityManager, Request $request): Response
    {
        //creamos el formulario que apunta a la clase ScheduleType
        $form = $this->createForm(ScheduleType::class);
        //manejamos la peticion
        $form->handleRequest($request);
        //nos permite validar el formulario con la informacion que se envia
       
        return $this->render('schedule/_schedule.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
