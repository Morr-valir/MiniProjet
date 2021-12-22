<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Client;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\Concessionnaire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

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
        yield MenuItem::linkToCrud('Type de modèle', 'fas fa-clipboard', Modele::class);
        yield MenuItem::section("Gestion des clients");
        yield MenuItem::linkToCrud('Client', 'fas fa-user', Client::class);
        yield MenuItem::section("Administration interface");
        yield MenuItem::linkToCrud('Gestion utilisateurs', 'fas fa-user', Admin::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
