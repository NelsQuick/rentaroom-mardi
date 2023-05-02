<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RoomController extends AbstractController
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    // Route qui affiche une room en particulier
    #[Route('/room/{id}', name: 'show_room', methods: ['GET', 'POST'])]
    public function show($id): Response
    {
        // Récupère la room demandée par son id
        $oneRoom = $this->entityManager->getRepository(Room::class)->findOneBy(['id' => $id]);

        // Affiche la room demandée dans le template dédié
        return $this->render('room/index.html.twig', [
            'oneRoom' => $oneRoom,
        ]);
    }
}