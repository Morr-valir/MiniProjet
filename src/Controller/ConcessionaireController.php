<?php

namespace App\Controller;

use App\Entity\Concessionnaire;
use App\Form\ConcessionaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcessionaireController extends AbstractController
{
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }


    /**
     * @Route("/showAll", name="showAll")
     */
    public function showAll(): Response
    {   

        $em = $this->doctrine->getManager();
        $repo = $em->getRepository(Concessionnaire::class);

        $listeConcession = $repo->findAll();

        return $this->render('concessionaire/index.html.twig', [
            'listeConcession' => $listeConcession,
        ]);
    }

    
    /**
     * @Route("/add", name="add")
     */
    public function add(Request $req): Response
    {

        //Récupération du manager
        $em = $this->doctrine->getManager();

        $concession1 = new Concessionnaire();
        $concession1->setNom("Concession 1");

        $form = $this->createForm(ConcessionaireType::class, $concession1);

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
             $concession1 = $form->getData();
             $em->persist($concession1);
             $em->flush();
        }

        return $this->renderForm('concessionaire/ajoutConcess.html.twig', [
            'form' => $form,
        ]);
    }
}
