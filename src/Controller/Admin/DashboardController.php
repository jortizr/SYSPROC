<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use App\Entity\Nomina;
use App\Entity\JobTitle;
use App\Entity\Schedule;
use App\Entity\State;
use App\Entity\TypeHour;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Option 1. You can make your dashboard redirect to some common page of your backend
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        
        return $this->redirect($adminUrlGenerator->setController(EmployeeCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sistema de gestion de procesos');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Nomina - GH');
        yield MenuItem::linkToCrud('Empleados', 'fas fa-users', Employee::class);
        yield MenuItem::linkToCrud('Cargos', 'fas fa-helmet-safety', JobTitle::class);
        yield MenuItem::linkToCrud('Horarios', 'fa-solid fa-calendar-days', Schedule::class);
        yield MenuItem::linkToCrud('Estados', 'fa-solid fa-bookmark', State::class);
        yield MenuItem::linkToCrud('Tipo de horas', 'fas fa-clock', TypeHour::class);
        yield MenuItem::linkToCrud('Nomina', 'fas fa-receipt', Nomina::class);
    }
}
