<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/marque", name="marque/")
 */
class MarqueController extends AbstractController
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
    public function showAll(): Response
    {
        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();


        $em = $this->doctrine->getManager();
        $repo = $em->getRepository(Marque::class);
        $listemarque = $repo->findAll();
        dump($listemarque);
        return $this->render('marque/marque.html.twig', [
            'listeMarque' => $listemarque,
            'user' => $lastUsername,
            'title' => 'Platefome de vente automobile - Liste des marques '
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $req): Response
    {
        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();

        $em = $this->doctrine->getManager();
        $marque = new Marque();
        $formulaire = $this->createForm(MarqueType::class, $marque)->add('Ajouter', SubmitType::class, [
            'attr' => ['class' => 'btn-success']
        ])->add('Annuler', ButtonType::class, [
            'attr' => [
                'onclick' => "location='/marque/showAll'",
                'class' => 'btn-danger'
            ]
        ]);
        //Validation formulaire
        $formulaire->handleRequest($req);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $marque = $formulaire->getData();

            $em->persist($marque);

            $tableauConcession = $marque->getConcessionnaires();
            foreach ($tableauConcession as $concessionnaire) {
                $concessionnaire->addMarque($marque);
                $em->flush();
            }


            $em->flush();
            return $this->redirectToRoute('marque/showAll');
        }

        return $this->renderForm('marque/addMarque.html.twig', [
            'form' => $formulaire,
            'user' => $lastUsername,
            'title' => 'Platefome de vente automobile - Création de marque '
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

        //Récupération de la marque ciblé
        $marque = $em->getRepository(Marque::class)->find($id);


        //Si la marque ciblé n'existe pas
        if (!$marque) {
            throw $this->createNotFoundException('Pas de marque dans la bdd');
        }

        //Création du formulaire
        $form = $this->createForm(MarqueType::class, $marque)->add('Valider', SubmitType::class, [
            'attr' => [
                'class' => 'btn-primary'
            ]
        ]);

        //Validation du formulaire
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $marque = $form->getData();
            $tableauConcession = $marque->getConcessionnaires();
            foreach ($tableauConcession as $concessionnaire) {
                $concessionnaire->addMarque($marque);
                $em->flush();
            }
            dump($marque);
            $em->flush();
            return $this->redirectToRoute('marque/showAll');
        }

        //Ensuite pour finir on envoie ce formualire au front, addMarque.html.twig
        return $this->renderForm('marque/addMarque.html.twig', [
            'form' => $form,
            'user' => $lastUsername,
            'title' => "Plateforme de vente automobile - Modification d''une marque'"
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(int $id): Response
    {

        $error = $this->Username->getLastAuthenticationError();
        $lastUsername = $this->Username->getLastUsername();


        //Récurepation du managaer
        $em = $this->doctrine->getManager();

        //Récupération du repository
        $repo = $em->getRepository(Marque::class);

        //Récupération de la concession ciblé
        $marque = $repo->find($id);

        //Si la concession ciblé n'existe pas 
        if (!$marque) {
            throw $this->createNotFoundException('Marque inexistante');
        }

        //Suppression de l'objet ciblé ($concession) en BDD
        $em->remove($marque);
        $em->flush();

        //Ensuite pour finir on re rend notre page d'accueil (index.html.twig)
        return $this->redirectToRoute('marque/showAll');
    }
}
