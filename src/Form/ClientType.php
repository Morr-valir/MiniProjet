<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Modele;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{

    //Creation du constructor pour recup data Marque
    private $doctrine;
    public function __construct(ManagerRegistry $doc)
    {
        $this->doctrine = $doc;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $repo = $this->doctrine->getManager()->getRepository(Modele::class);
        $listeModele = $repo->findAll();

        $builder
            ->add('nom')
            ->add('prenom')
            ->add("modele", EntityType::class, [
                'label' => "Choix du modele",
                'class' => Modele::class,
                'multiple' => false,
                'choices' => $listeModele,
                'required' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
