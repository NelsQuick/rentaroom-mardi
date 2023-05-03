<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Form\BookingType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    // Route pour afficher le formulaire de réservation d'une chambre
    #[Route('/reservation/{id}', name: 'app_reservation')]
    public function reserveRoomAction(Request $request, ManagerRegistry $doctrine, $id)
    {
        // Récupérer l'objet de la chambre correspondant à l'id dans l'URL
        $room = $doctrine->getRepository(Room::class)->find($id);

        // Si la chambre n'existe pas, renvoyer une erreur 404
        if (!$room) {
            throw $this->createNotFoundException('The room does not exist');
        }

        // Créer un objet Reservation avec la chambre associée
        $reservation = new Reservation();
        $reservation->setRoom($room);

        // Créer un formulaire pour la réservation de la chambre
        $form = $this->createFormBuilder($reservation)
            ->add('startDate', DateTimeType::class, [
                'data' => new \DateTime('Europe/Paris'),
            ])
            ->add('endDate', DateTimeType::class, [
                'data' => new \DateTime('Europe/Paris'),
            ])
            ->add('save', SubmitType::class, ['label' => 'Reserve'])
            ->getForm();

        // Traiter le formulaire lorsqu'il est soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est valide, récupérer les données du formulaire
            $reservation = $form->getData();

            // Associer la chambre et l'utilisateur connecté à la réservation
            $reservation->setRoom($room);
            $reservation->setUser($this->getUser()); // Si l'utilisateur est authentifié, sinon utilisez une autre méthode pour récupérer l'utilisateur

            // Enregistrer la réservation dans la base de données
            $entityManager = $doctrine->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Rediriger l'utilisateur vers une page de confirmation
            return $this->render('reservation/success.html.twig');
        }

        // Afficher le formulaire de réservation de la chambre
        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'room' => $room,
        ]);
    }
}
