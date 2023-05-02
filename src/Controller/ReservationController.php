<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Form\BookingType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormTypeInterface;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'app_reservation')]
    public function reserveRoomAction(Request $request, ManagerRegistry $doctrine, $id)
    {
        $roomId = $request->query->get('room');
        $room = $doctrine->getRepository(Room::class)->find($id);
    
        if (!$room) {
            throw $this->createNotFoundException('The room does not exist');
        }
    
        $reservation = new Reservation();
        $reservation->setRoom($room);
    
        $form = $this->createFormBuilder($reservation)
        ->add('startDate', DateTimeType::class)
        ->add('endDate', DateTimeType::class)
        ->add('save', SubmitType::class, ['label' => 'Reserve'])
        ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $reservation->setRoom($room);
            $reservation->setUser($this->getUser()); // Si l'utilisateur est authentifié, sinon utilisez une autre méthode pour récupérer l'utilisateur
            $entityManager = $doctrine->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();
        
            return $this->render('reservation/success.html.twig');
        }
    
        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'room' => $room,
        ]);
    }
}