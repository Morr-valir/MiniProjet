<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Service\appelAPI;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/client", name="client/")
 */

class ClientController extends AbstractController
{
    private $doctrine;
    private $Username;
    public function __construct(ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils)
    {
        $this->doctrine = $doctrine;
        $this->Username = $authenticationUtils;
    }

    /**
     * @Route("/showAll", name="showAll")
     */
    public function showAll(ManagerRegistry $doctrine, appelAPI $appelAPI): Response
    {
        // dd($appelAPI->getConcessionnaire());

        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();


        $em = $doctrine->getManager();
        $repo = $em->getRepository(Client::class);
        $listeAll = $repo->findAll();

        return $this->render('client/showAllClient.html.twig', [
            'listeAll' => $listeAll,
            'user' => $lastUsername,
            'title' => 'Platefome de vente automobile - Liste des clients'
        ]);
    }
    

    
    /**
     * @Route("/jsonFile", name="jsonFile")
     */
    public function getJson(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $repo = $em->getRepository(Client::class);
        $listeAll = $repo->findAll();
        
        return $this->json($listeAll);
    }

    /**
     * @Route("/showSelected/{id}", name="showSelected")
     */
    public function showSelected(ManagerRegistry $doctrine, int $id): Response
    {
        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();

        $em = $doctrine->getManager();
        $repoClient = $em->getRepository(Client::class);

        $clientSelected = $repoClient->find($id);

        return $this->render('client/showSelectedClient.html.twig', [
            'clientSelected' => $clientSelected,
            'user' => $lastUsername,
            'title' => 'Platefome de vente automobile - Liste des clients'
        ]);
    }



    /**
     * @Route("/add", name="add")
     */
    public function add(Request $req): Response
    {
        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();

        //Récupération du manager
        $em = $this->doctrine->getManager();
        $repoClient = $em->getRepository(Client::class);

        $client1 = new Client();

        //Création du formulaire
        $form = $this->createForm(ClientType::class, $client1)->add('Soumettre', SubmitType::class, [
            'attr' => [
                'class' => 'btn-success'
            ]
        ])->add('Annuler', ButtonType::class, [
            'attr' => [
                'class' => 'btn-danger',
                'onclick' => "location='/client/showAll'"
            ]
        ]);


        //Validation du formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            if ($client->getModele() != null) {
                $modeleToCheck = $client->getModele();
                if ($clientAttached = $repoClient->findOneBy([
                    'modele' => $modeleToCheck,
                ])) {
                    $clientAttached->setModele(null);
                }
                $em->flush();
            }

            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('client/showAll');
        }

        //Ensuite pour finir on envoie ce formulaire au front, ajoutConcess.html.twig
        return $this->renderForm('client/addClient.html.twig', [
            'form' => $form,
            'user' => $lastUsername,
            'title' => 'Plateforme de vente automobile - Ajout de client'
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $req, int $id): Response
    {
        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();

        //Récupération du manager
        $em = $this->doctrine->getManager();
        $repoClient = $em->getRepository(Client::class);

        //Récupération du client ciblé
        $client = new Client();
        $client = $repoClient->find($id); 
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

            $modeleToCheck = $client->getModele();
            $c=$repoClient->findOneBy(['modele' => $modeleToCheck,]);
            $client->setModele(null); 
            //Si le client est déja lié on enlève le lien
            if($c != null ){
                //On enlève les relations des deux cotés
                $c->setModele(null);
                $em->flush(); 
            }
            $client->setModele($modeleToCheck);
            $em->flush();
            return $this->redirectToRoute('client/showAll');
        }

        //Ensuite pour finir on envoie ce formualire au front, addMarque.html.twig
        return $this->renderForm('client/addClient.html.twig', [
            'form' => $form,
            'user' => $lastUsername,
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
