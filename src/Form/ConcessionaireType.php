<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Concessionnaire;
use Symfony\Component\Form\AbstractType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConcessionaireType extends AbstractType
{
    //Creation du constructor pour recup data Marque
    private $doctrine;
    public function __construct(ManagerRegistry $doc)
    {
        $this->doctrine = $doc;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $repo = $this->doctrine->getManager()->getRepository(Marque::class);
        $listeConcession = $repo->findAll();
        $builder
            ->add('nom')
            ->add("marques", EntityType::class, [
                'label' => "Choix de la marque",
                'class' => Marque::class,
                'multiple' => true,
                'choices' => $listeConcession,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Concessionnaire::class,
        ]);
    }
}
