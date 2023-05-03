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
        // On ajoute les différents champs au formulaire
        $builder
            ->add('room', EntityType::class, [
                'class' => 'App\Entity\Room', // Classe de l'entité liée au champ
                'choice_label' => 'name', // Champ utilisé pour afficher les options dans le select
                'label' => 'Select a room', // Label du champ
            ])
            ->add('startDate', DateTimeType::class, [
                'label' => 'Start date and time', // Label du champ
            ])
            ->add('endDate', DateTimeType::class, [
                'label' => 'End date and time', // Label du champ
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Reserve', // Label du bouton submit
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // On configure les options du formulaire
        $resolver->setDefaults([
            'data_class' => Reservation::class, // Classe de l'entité liée au formulaire
        ]);
    }
}
