<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\JobTitle;
use App\Entity\Schedule;
use App\Entity\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('name')
            ->add('cc')
            ->add('ID_State', EntityType::class, [
                'class' => State::class,
                'choice_label' => 'id',
            ])
            ->add('Cod_JobTitle', EntityType::class, [
                'class' => JobTitle::class,
                'choice_label' => 'id',
            ])
            ->add('Id_schedule', EntityType::class, [
                'class' => Schedule::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
