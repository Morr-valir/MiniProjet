<?php

namespace App\Form;

use App\Entity\Concessionnaire;
use App\Entity\Marque;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarqueType extends AbstractType

{    //Creation du constructor pour recup data Marque
    private $doctrine;
    public function __construct(ManagerRegistry $doc)
    {
        $this->doctrine = $doc;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $repo = $this->doctrine->getManager()->getRepository(Concessionnaire::class);
        $listeMarque = $repo->findAll();
        $builder
            ->add('nom')
            ->add("concessionnaires", EntityType::class, [
                'label' => "Choix de du concessionnaire",
                'class' => Concessionnaire::class,
                'multiple' => true,
                'choices' => $listeMarque
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Marque::class,
        ]);
    }
}
