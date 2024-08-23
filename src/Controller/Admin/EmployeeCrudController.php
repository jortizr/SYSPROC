<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class EmployeeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employee::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Colaborador')
            ->setEntityLabelInPlural('Colaboradores')
            ->setSearchFields(['id', 'name', 'cc'])
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id', 'Cod. Nomina'),
            TextField::new('name', 'Nombre completo'),
            NumberField::new('cc', 'Cedula'),
            AssociationField::new('ID_State', 'Estado Colaborador'),
            AssociationField::new('Cod_JobTitle', 'Cargo'),
            AssociationField::new('Id_schedule', 'Horario laboral'),
        ];
    }

}
