<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/modele', name: 'modele')]
class ModeleController extends AbstractController
{
    #[Route('/showAll', name: 'showAll')]
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $repo = $em->getRepository(Modele::class);
        
        $listeModele = $repo->findAll();

        return $this->render('modele/showAll.html.twig', [
            'listeModele' => $listeModele,
        ]);
    }
}
