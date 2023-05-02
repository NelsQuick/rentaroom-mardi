<?php

namespace App\Controller\Admin;

// Chargement des entitées
use App\Entity\Room;
use App\Entity\User;
use App\Entity\Ergonomics;
use App\Entity\Material;
use App\Entity\Reservation;
use App\Entity\Software;

// Chargement des Bundles et composants
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');

                // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(RoomCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('Rentaroom App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Reservation', 'fas fa-list', Reservation::class);
        yield MenuItem::linkToCrud('Room', 'fas fa-list', Room::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Software', 'fas fa-list', Software::class);
        yield MenuItem::linkToCrud('Material', 'fas fa-list', Material::class);
        yield MenuItem::linkToCrud('Ergonomics', 'fas fa-list', Ergonomics::class);
    }
}