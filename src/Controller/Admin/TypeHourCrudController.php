<?php

namespace App\Controller\Admin;

use App\Entity\TypeHour;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class TypeHourCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeHour::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Tipo de hora laboral')
            ->setEntityLabelInPlural('Tipos de horas laborales')
            
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name_hrs', 'Nombre del tipo de hora'),
        ];
    }
}
