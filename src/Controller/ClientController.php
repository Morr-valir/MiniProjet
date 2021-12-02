<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'client')]
        public function showAll(ManagerRegistry $doctrine): Response
        {
            $em = $doctrine->getManager();
            $repo = $em->getRepository(Modele::class);
            
            $listeClient = $repo->findAll();

        return $this->render('client/showAllClient.html.twig', [
            'listeClient' => $listeClient,
        ]);
    }
}
