<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmployeeController extends AbstractController
{
    #[Route('HR/employees', name: 'app_employees')]
    public function index(): Response
    {
        return $this->render('employee/main_employees.html.twig');
    }
}
