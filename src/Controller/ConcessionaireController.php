<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcessionaireController extends AbstractController
{
    /**
     * @Route("/concessionaire", name="concessionaire")
     */
    public function index(): Response
    {
        return $this->render('concessionaire/index.html.twig', [
            'controller_name' => 'ConcessionaireController',
        ]);
    }
}
