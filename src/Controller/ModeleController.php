<?php

namespace App\Controller;

use App\Entity\Modele;
use App\Form\ModeleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/modele", name="modele/")
 */

class ModeleController extends AbstractController
{


    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }



    /**
     * @Route("/add", name="add")
     */
    public function add(Request $req): Response
    {

        //Récupération du manager
        $em = $this->doctrine->getManager();

        $modele = new Modele();

        //Création du formulaire
        $form = $this->createForm(ModeleType::class, $modele)->add('Soumettre', SubmitType::class, [
            'attr' => [
                'class' => 'btn-success'
            ]
        ])->add('Annuler', ButtonType::class, [
            'attr' => [
                'class' => 'btn-danger'
            ]
        ]);


        //Validation du formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $modele = $form->getData();

            $em->persist($modele);
            $em->flush();
            return $this->redirectToRoute('modele/showAll');
        }

        //Ensuite pour finir on envoie ce formulaire au front, ajoutModele.html.twig
        return $this->renderForm('modele/ajoutModele.html.twig', [
            'form' => $form,
            'title' => 'Plateforme de vente automobile - Liste des modeles'
        ]);
    }

    /**
     * @Route("/showAll", name="showAll")
     */
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $repo = $em->getRepository(Modele::class);

        $listeModele = $repo->findAll();

        return $this->render('modele/showAll.html.twig', [
            'listeModele' => $listeModele,
        ]);
    }



    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $req, int $id): Response
    {
        //Récupération du manager
        $em = $this->doctrine->getManager();

        //Récupération du modele ciblé
        $modele = $em->getRepository(Modele::class)->find($id);


        //Si la concession ciblé n'existe pas
        if (!$modele) {
            throw $this->createNotFoundException('Pas de modele dans la bdd');
        }

        //Création du formulaire
        $form = $this->createForm(ModeleType::class, $modele)->add('Valider', SubmitType::class, [
            'attr' => [
                'class' => 'btn-primary'
            ]
        ]);

        //Validation du formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $modele = $form->getData();

            $em->flush();
            return $this->redirectToRoute('modele/showAll');
        }

        //Ensuite pour finir on envoie ce formualire au front, ajoutConcess.html.twig
        return $this->renderForm('modele/ajoutModele.html.twig', [
            'form' => $form,
            'title' => "Plateforme de vente automobile - Modification d''un modele'"
        ]);
    }


    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(int $id): Response
    {

        //Récurepation du managaer
        $em = $this->doctrine->getManager();

        //Récupération du repository
        $repo = $em->getRepository(Modele::class);

        //Récupération de la concession ciblé
        $modele = $repo->find($id);

        //Si la concession ciblé n'existe pas 
        if (!$modele) {
            throw $this->createNotFoundException('Modele inexistante');
        }

        //Suppression de l'objet ciblé ($modele) en BDD
        $em->remove($modele);
        $em->flush();

        //Ensuite pour finir redirige vers l'affichage de tout nos modele
        return $this->redirectToRoute('modele/showAll');
    }
}
