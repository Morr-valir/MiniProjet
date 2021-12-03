<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Modele;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/client", name="client/")
 */

class ClientController extends AbstractController
{
    /**
     * @Route("/showAll", name="showAll")
     */
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        $repo = $em->getRepository(Client::class) ;

        $listeAll = $repo->findAll();

        return $this->render('client/showAllClient.html.twig', [
            'listeAll' => $listeAll,
            'title' => 'Platefome de vente automobile - Liste des clients'
        ]);
    }
}
