<?php

namespace App\Controller\Admin;

use App\Entity\Nomina;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class NominaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Nomina::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Nomina')
            ->setEntityLabelInPlural('Nominas');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('id_employee', 'Cod_Nomina'),
            DateField::new('Date_start', 'Fecha inicio'),
            DateField::new('Date_end', 'Fecha final'),
            NumberField::new('fortnight', 'N° Quincena'),
            NumberField::new('amount', 'Cantidad'),
            AssociationField::new('typeHour'),
        ];
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
