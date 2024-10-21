<?php

namespace App\Controller;

use App\Entity\Schedule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ScheduleType;


class ScheduleController extends AbstractController
{
    #[Route('/HR/schedule', name: 'app_schedule')]
    public function schedule(EntityManagerInterface $entityManager): Response
    {
        $listSchedules = $entityManager->getRepository(Schedule::class)->findAll();

        return $this->render('schedule/_schedule_list.html.twig',[
            'listSchedules' =>$listSchedules
        ]);
    }

    #[Route('/HR/schedule_new', name: 'app_schedule_add')]
    public function addSchedule(EntityManagerInterface $entityManager, Request $request): Response
    {
        //creamos el formulario que apunta a la clase ScheduleType
        $form = $this->createForm(ScheduleType::class);
        //manejamos la peticion
        $form->handleRequest($request);
        
        //nos permite validar el formulario con la informacion que se envia
        if ($form->isSubmitted() && $form->isValid()) {
            $schedule = $form->getData();
            
            $schedule->setModDate(date('Y-m-d H:i:s'));
            
            $entityManager->persist($schedule);
            $entityManager->flush();
            return $this->redirectToRoute('app_schedule');
        }
        return $this->render('schedule/_schedule_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}
