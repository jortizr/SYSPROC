<?php

namespace App\Controller;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmployeeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('HR/employees', name: 'app_employees')]
    public function getEmployees(): Response
    {   
        $headers =["Cod. nomina","Nombre completo","CC","Estado","Cargo","Horario"];
        
        $listEmployees = $this->entityManager->getRepository(Employee::class)->findAll();

        return $this->render('employee/_list_employees.html.twig', [
            'headers' => $headers,
            'listEmployees' => $listEmployees
        ]);
    }

    #[Route('HR/employees/add', name: 'add_employees')]
    public function newEmployee(): Response
    {
        return $this->render('employee/_add_employee.html.twig');
    }



}
