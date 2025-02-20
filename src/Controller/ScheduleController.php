<?php

namespace App\Controller;

use App\Entity\Schedule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ScheduleType;
use App\Repository\ScheduleRepository;

class ScheduleController extends AbstractController
{
    private $entityManager;
    private $scheduleRepo;

    function __construct(EntityManagerInterface $entityManager, ScheduleRepository $scheduleRepo){
        $this->entityManager = $entityManager;
        $this->scheduleRepo = $scheduleRepo;
    }

    #[Route('/HR/schedule', name: 'app_schedule')]
    public function schedule(): Response
    {
        $listSchedules = $this->entityManager->getRepository(Schedule::class)->findAll();

        return $this->render('schedule/_schedule_list.html.twig',[
            'listSchedules' =>$listSchedules
        ]);
    }

    #[Route('/HR/schedule_new', name: 'app_schedule_add')]
    public function addSchedule(Request $request): Response
    {
        //creamos el formulario que apunta a la clase ScheduleType
        $form = $this->createForm(ScheduleType::class);
        //manejamos la peticion
        $form->handleRequest($request);
        
        //nos permite validar el formulario con la informacion que se envia
        if ($form->isSubmitted() && $form->isValid()) {
            $schedule = $form->getData();
            
            $schedule->setModDate(date('Y-m-d H:i:s'));
            
            $this->entityManager->persist($schedule);
            $this->entityManager->flush();
            $this->addFlash('success', 'Se ha guardado correctamente ');
            return $this->redirectToRoute('app_schedule');
        }
        return $this->render('schedule/_schedule_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/HR/schedule/delete/{id}', name: 'app_schedule_delete', methods: ['POST'])]
    public function delete(ScheduleRepository $scheduleRepository, int $id, Request $request): RedirectResponse
    {
       
        //verificar el  token CSRF
        $submittedToken = $request->getPayload()->get('token');
        //validacion del token
        if(!$this->isCsrfTokenValid('delete-item', $submittedToken)){
            $this->addFlash('error', 'Token CSRF invalido. No se completo tu solicitud');
            return $this->redirectToRoute('app_schedule');
        }
        //buscar el horario a eliminar
        $schedule = $scheduleRepository->find($id);
        //validar si existe el horario
        if(!$schedule){
            $this->addFlash('error', 'No se encontró el horario.');
            return $this->redirectToRoute('app_schedule');
        }
        //eliminar el horario con la funcion predeterminada de doctrine preparada
        $this->entityManager->remove($schedule);
        $this->entityManager->flush();

        $this->addFlash('success', 'Se ha eliminado correctamente');
        return $this->redirectToRoute('app_schedule');
    }

    #[Route('/HR/schedule/edit/{id}', name: 'app_schedule_edit', methods:['POST'])]
    public function scheduleEdit(int $id, Request $request): Response
    {  
        //cargar el objeto
        $schedule = $this->scheduleRepo->find($id);
        
        if(!$schedule){
            $this->addFlash('error', 'El horario no existe.');
        }

        //creacion del formulario y pasar el objeto con los datos
        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);

        //valida si el formulario es valido
        if($form->isSubmitted() && $form->isValid()){
            //guardar los cambios
            $this->entityManager->flush();

            $this->addFlash('sucess', 'Horario actualizado');
            return $this->redirectToRoute('app_schedule');
        }

        return $this->render('schedule/_schedule_edit.html.twig', [
            'form' => $form->createView(),
            'schedule' => $schedule
        ]);
    }

}
