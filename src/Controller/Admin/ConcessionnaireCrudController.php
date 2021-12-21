<?php

namespace App\Controller\Admin;

use App\Entity\Concessionnaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConcessionnaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Concessionnaire::class;
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
