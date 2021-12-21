<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MarqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Marque::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
