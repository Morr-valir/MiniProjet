<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Modele;
use App\Form\ClientType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/client", name="client/")
 */

class ClientController extends AbstractController
{
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/showAll", name="showAll")
     */
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        $repo = $em->getRepository(Client::class);

        $listeAll = $repo->findAll();
        dump($listeAll);
        return $this->render('client/showAllClient.html.twig', [
            'listeAll' => $listeAll,
            'title' => 'Platefome de vente automobile - Liste des clients'
        ]);
    }
    /**
     * @Route("/add", name="add")
     */
    public function add(Request $req): Response
    {

        //Récupération du manager
        $em = $this->doctrine->getManager();

        $client1 = new Client();

        //Création du formulaire
        $form = $this->createForm(ClientType::class, $client1)->add('Soumettre', SubmitType::class, [
            'attr' => [
                'class' => 'btn-success'
            ]
        ])->add('Annuler', ButtonType::class, [
            'attr' => [
                'class' => 'btn-danger',
                'onclick' =>"location='/client/showAll"
            ]
        ]);


        //Validation du formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $client1 = $form->getData();

            $em->persist($client1);
            $em->flush();
            return $this->redirectToRoute('client/showAll');
        }

        //Ensuite pour finir on envoie ce formulaire au front, ajoutConcess.html.twig
        return $this->renderForm('client/addClient.html.twig', [
            'form' => $form,
            'title' => 'Plateforme de vente automobile - Ajout de client'
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $req, int $id): Response
    {
        //Récupération du manager
        $em = $this->doctrine->getManager();

        //Récupération du client ciblé
        $client = $em->getRepository(Client::class)->find($id);


        //Si la marque ciblé n'existe pas
        if (!$client) {
            throw $this->createNotFoundException('Pas de marque dans la bdd');
        }

        //Création du formulaire
        $form = $this->createForm(ClientType::class, $client)->add('Valider', SubmitType::class, [
            'attr' => [
                'class' => 'btn-primary'
            ]
        ]);

        //Validation du formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            $em->flush();
            return $this->redirectToRoute('client/showAll');
        }

        //Ensuite pour finir on envoie ce formualire au front, addMarque.html.twig
        return $this->renderForm('client/addClient.html.twig', [
            'form' => $form,
            'title' => "Plateforme de vente automobile - Modification d''un client'"
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
        $repo = $em->getRepository(Client::class);

        //Récupération de la concession ciblé
        $client = $repo->find($id);

        //Si la concession ciblé n'existe pas 
        if (!$client) {
            throw $this->createNotFoundException('Client inexistant');
        }

        //Suppression de l'objet ciblé ($client) en BDD
        $em->remove($client);
        $em->flush();

        //Ensuite pour finir redirige vers l'affichage de tout nos modele
        return $this->redirectToRoute('client/showAll');
    }
}
