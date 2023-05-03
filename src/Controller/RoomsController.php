<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use App\Entity\Material;
use App\Entity\Software;
use App\Entity\Ergonomics;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RoomsController extends AbstractController
{
    // Cette méthode est associée à l'URL "/rooms"
    #[Route('/rooms', name: 'app_rooms')]
    public function roomsAction(Request $request, ManagerRegistry $doctrine, RoomRepository $RoomRepository)
    {
        // Récupération de tous les objets Room à partir du RoomRepository
        $rooms = $RoomRepository->findAll();

        // Création du formulaire de filtre pour filtrer les objets Room
        $form = $this->createFormBuilder()
            ->add('capacity')

            ->add('material', EntityType::class, [
                'class' => Material::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('software', EntityType::class, [
                'class' => Software::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('ergonomics', EntityType::class, [
                'class' => Ergonomics::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('filter', SubmitType::class, [
                'label' => 'Send',
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->getForm();

        // Traitement du formulaire de filtre
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération des données du formulaire
            $data = $form->getData();

            // Affichage des données pour débogage
            // dump($data);
            // die();

            // Récupération des objets Room filtrés à partir du RoomRepository
            $rooms = $RoomRepository->findByCriteria($data);
        }

        // Renvoi de la réponse (rendu de la vue Twig "rooms/index.html.twig")
        return $this->render('rooms/index.html.twig', [
            'rooms' => $rooms,
            'form' => $form->createView(),
        ]);
    }
}
