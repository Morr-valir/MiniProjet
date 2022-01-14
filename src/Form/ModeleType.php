<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Marque;
use App\Entity\Modele;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeleType extends AbstractType
{
    //Creation du constructor pour recup data Hero
    private $doctrine;
    public function __construct(ManagerRegistry $doc)
    {
        $this->doctrine = $doc;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $repoClient = $this->doctrine->getManager()->getRepository(Client::class);
        $listeClient = $repoClient->findAll();
        dump($listeClient);

        $repoMarque = $this->doctrine->getManager()->getRepository(Marque::class);
        $listeMarque = $repoMarque->findAll();
        dump($listeMarque);


        $builder
            ->add('nom')
            ->add("marque", EntityType::class, [
                'label' => "Marque",
                'class' => Marque::class,
                'multiple' => true,
                'choices' => $listeMarque
            ])
            ->add("clients", EntityType::class, [
                'label' => "Client intéréssé",
                'class' => Client::class,
                'multiple' => true,
                'choices' => $listeClient,
                'required' => false
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Modele::class,
        ]);
    }
}
