<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/marque", name="marque/")
 */
class MarqueController extends AbstractController
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
        $repo = $em->getRepository(Marque::class);
        $listemarque = $repo->findAll();
        dump($listemarque);
        return $this->render('marque/marque.html.twig', [
            'listeMarque' => $listemarque,
            'title' => 'Platefome de vente automobile - Liste des marques '
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $req): Response
    {
        $em = $this->doctrine->getManager();
        $marque = new Marque();
        $formulaire = $this->createForm(MarqueType::class, $marque)->add('Ajouter', SubmitType::class, [
            'attr' => ['class' => 'btn-success']
        ]);
        //Validation formulaire
        $formulaire->handleRequest($req);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $marque = $formulaire->getData();
            $em->persist($marque);
            $em->flush();
            return $this->redirectToRoute('marque/showAll');
        }

        return $this->renderForm('marque/addMarque.html.twig', [
            'form' => $formulaire,
            'title' => 'Platefome de vente automobile - Création de marque '
        ]);
    }
}
