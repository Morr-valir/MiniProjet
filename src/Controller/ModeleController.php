<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Marque;
use App\Entity\Modele;
use App\Form\ModeleType;
use App\Repository\ClientRepository;
use App\Repository\ModeleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * @Route("/modele", name="modele/")
 */

class ModeleController extends AbstractController
{


    private $doctrine;
    private $manager;
    private $Username;
    private $repoClients;
    private $repoModeles;
    public function __construct(EntityManagerInterface $manager, ClientRepository $repoClients, ModeleRepository $repoModeles,  ManagerRegistry $doctrine, AuthenticationUtils $authenticationUtils)
    {
        $this->doctrine = $doctrine;
        $this->Username = $authenticationUtils;
        $this->repoClients = $repoClients;
        $this->repoModeles = $repoModeles;
        $this->manager = $manager;
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

        $modele = new Modele();

        //Création du formulaire
        $form = $this->createForm(ModeleType::class, $modele)->add('Soumettre', SubmitType::class, [
            'attr' => [
                'class' => 'btn-success'
            ]
        ])->add('Annuler', ButtonType::class, [
            'attr' => [
                'class' => 'btn-danger',
                'onclick' => "location='/modele/showAll'"
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
            'user' => $lastUsername,
            'title' => 'Plateforme de vente automobile - Liste des modeles'
        ]);
    }

    /**
     * @Route("/showAll", name="showAll")
     */
    public function showAll(ManagerRegistry $doctrine): Response
    {
        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();

        //listes des données clients & modeles
        $listeClients = $this->repoClients->findAll();
        $listeModeles = $this->repoModeles->findAll();

        return $this->render('Navigation/listesModele.html.twig', [
            'listeModele' => $listeModeles,
            'listeClient' => $listeClients,
            'user' => $lastUsername,
        ]);
    }


    /**
     * @Route("/showSelected/{id}", name="showSelected")
     */
    public function showSelected(ManagerRegistry $doctrine, int $id): Response
    {
        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();

        $em = $doctrine->getManager();
        $repoMarque = $em->getRepository(Marque::class);

        $marqueSelected = $repoMarque->find($id);
        $listeModele = $marqueSelected->getModeles();
        dump($listeModele);

        return $this->render('Navigation/listesModele.html.twig', [
            'listeModele' => $listeModele,
            'user' => $lastUsername,
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

            // if ($modele->getClients()->getModele() != null) {
            //     dump("Passage dans le if");
            //     $modele->getClients()->setModele(null);
            //     $em->flush();
            // } else {
            //     dump("Passage dans le else");
            //     $em->flush();
            // }


            $em->flush();
            return $this->redirectToRoute('modele/showAll');
        }

        //Ensuite pour finir on envoie ce formualire au front, ajoutConcess.html.twig
        return $this->renderForm('modele/ajoutModele.html.twig', [
            'form' => $form,
            'user' => $lastUsername,
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

        //Récupération des repository
        $repo = $em->getRepository(Modele::class);
        $repoClient = $em->getRepository(Client::class);

        //Récupération du model ciblé
        $modele = $repo->find($id);

        //Si le modele ciblé n'existe pas 
        if (!$modele) {
            throw $this->createNotFoundException('Modele inexistante');
        }

        //Suppression de l'objet ciblé ($modele) en BDD

        if ($clientAttached = $repoClient->findOneBy([
            'modele' => $modele,
        ])) {
            $clientAttached->setModele(null);
            $em->flush();
        }

        $em->remove($modele);
        $em->flush();

        //Ensuite pour finir redirige vers l'affichage de tout nos modele
        return $this->redirectToRoute('modele/showAll');
    }
}
