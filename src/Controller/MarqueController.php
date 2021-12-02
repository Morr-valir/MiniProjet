<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController extends AbstractController
{
    /**
     * @Route("/marque", name="marque")
     */
    public function index(): Response
    {
        return $this->render('marque/marque.html.twig', [
            'controller_name' => 'MarqueController',
        ]);
    }
}
