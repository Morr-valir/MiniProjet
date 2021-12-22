<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use App\Entity\Concessionnaire;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConcessionnaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Concessionnaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom du concessionnaire'),
            AssociationField::new('marques', 'Marque du concessionnaire'),
        ];
    }
}
