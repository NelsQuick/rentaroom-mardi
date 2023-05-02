<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\RoomRepository;
use App\Entity\Material;
use App\Entity\Software;
use App\Entity\Ergonomics;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class RoomsController extends AbstractController
{
    #[Route('/rooms', name: 'app_rooms')]
    public function roomsAction(Request $request, ManagerRegistry $doctrine, RoomRepository $RoomRepository)
    {
        $rooms = $RoomRepository->findAll();

        $form = $this->createFormBuilder()
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
                'label' => 'Valider',
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dump($data);
            die();
            $rooms = $RoomRepository->findByCriteria($data);
            
        }

        return $this->render('rooms/index.html.twig', [
            'rooms' => $rooms,
            'form' => $form->createView(),
        ]);
    }
}
