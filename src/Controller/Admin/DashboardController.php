<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\Concessionnaire;
use App\Entity\Marque;
use App\Entity\Modele;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Interface de gestion');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section("Configurations");
        yield MenuItem::linkToCrud('Concessionaire', 'fas fa-industry', Concessionnaire::class);
        yield MenuItem::linkToCrud('Marque', 'fas fa-car', Marque::class);
        yield MenuItem::linkToCrud('Marque', 'fas fa-clipboard', Modele::class);
        yield MenuItem::section("Gestion des clients");
        yield MenuItem::linkToCrud('Marque', 'fas fa-user', Client::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
