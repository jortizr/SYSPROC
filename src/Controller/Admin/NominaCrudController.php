<?php

namespace App\Controller\Admin;

use App\Entity\Nomina;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class NominaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Nomina::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('id_employee', 'Cod_Nomina'),
            DateField::new('date', 'Fecha'),
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
