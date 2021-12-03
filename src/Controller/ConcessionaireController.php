<?php

namespace App\Controller;

use App\Entity\Concessionnaire;
use App\Form\ConcessionaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

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
        //Récupération du manager
        $em = $this->doctrine->getManager();

        //Récupération du repository
        $repo = $em->getRepository(Concessionnaire::class);

        //Récupération de tout les objets du repository Concessionnaire
        $listeConcession = $repo->findAll();

        //Ensuite pour finir on envoie cette liste au front, index.html.twig
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

        //Création du formulaire
        $form = $this->createForm(ConcessionaireType::class, $concession1)->add('Soumettre', SubmitType::class, [
            'attr' => [
                'class' => 'btn-success'
            ]
        ])->add('Annuler', ButtonType::class, [
            'attr' => [
                'class' => 'btn-danger'            ]
        ]);


        //Validation du formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $concession1 = $form->getData();

            $em->persist($concession1);
            $em->flush();
            return $this->redirectToRoute('showAll');
        }

        //Ensuite pour finir on envoie ce formulaire au front, ajoutConcess.html.twig
        return $this->renderForm('concessionaire/ajoutConcess.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $req, int $id): Response
    {

        //Récupération du manager
        $em = $this->doctrine->getManager();

        //Récupération de la concession ciblé
        $concession = $em->getRepository(Concessionnaire::class)->find($id);


        //Si la concession ciblé n'existe pas
        if (!$concession) {
            throw $this->createNotFoundException('Pas de concession dans la bdd');
        }

        //Création du formulaire
        $form = $this->createForm(ConcessionaireType::class, $concession)->add('Mettre à jour', SubmitType::class, [
            'attr' => [
                'class' => 'btn-primary'
            ]
        ]);

        //Validation du formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $concession = $form->getData();

            $em->flush();
            return $this->redirectToRoute('showAll');
        }

        //Ensuite pour finir on envoie ce formualire au front, ajoutConcess.html.twig
        return $this->renderForm('concessionaire/ajoutConcess.html.twig', [
            'form' => $form,
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
        $repo = $em->getRepository(Concessionnaire::class);

        //Récupération de la concession ciblé
        $concession = $repo->find($id);

        //Si la concession ciblé n'existe pas 
        if (!$concession) {
            throw $this->createNotFoundException('Concession inexistante');
        }

        //Suppression de l'objet ciblé ($concession) en BDD
        $em->remove($concession);
        $em->flush();

        //Ensuite pour finir on re rend notre page d'accueil (index.html.twig)
        return $this->redirectToRoute('showAll');
    }
}
