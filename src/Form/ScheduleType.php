<?php

namespace App\Form;

use App\Entity\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

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
            'required' => false,
        ])
        ->add('time_2_end', TimeType::class, [
            'label' => 'Hora de fin del turno 2',
            'required' => false,
        ])
        ->add('weekend_time_start', TimeType::class, [
            'label' => 'Hora entrada fin de semana',
        ])
        ->add('weekend_time_end', TimeType::class, [
            'label' => 'Hora salida fin de semana',
        ])
        ->add('weekend_time_2_start', TimeType::class, [
            'label' => 'Hora entrada 2 fin de semana',
            'required' => false,
        ])
        ->add('weekend_time_2_end', TimeType::class, [
            'label' => 'Hora salida 2 fin de semana',
            'required' => false,
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
