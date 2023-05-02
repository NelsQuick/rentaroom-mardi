<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('room', EntityType::class, [
                'class' => 'App\Entity\Room',
                'choice_label' => 'name',
                'label' => 'Select a room',
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => 'Start date and time',
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'End date and time',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Reserve',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}