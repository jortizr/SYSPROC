<?php

namespace App\Form;

use App\Entity\Schedule;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nombre del horario',
                'attr' => [
                    "class" => "text-start",
                    'placeholder' => 'ingresa el nombre'
                    
                ],
            ])
            ->add('time_start', TimeType::class, [
              'label' => 'Hora de inicio del turno 1',
            ])
            ->add('time_end', TimeType::class, [
                'label' => 'Hora de fin del turno 1',
            ])
            ->add('time_2_start', TimeType::class, [
                'label' => 'Hora de inicio del turno 2',
            ])
            ->add('time_2_end', TimeType::class, [
                'label' => 'Hora de fin del turno 2',
            ])
            ->add('Guardar', SubmitType::class,[
                'attr' => ['class' => 'btn btn-outline-danger ']
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
