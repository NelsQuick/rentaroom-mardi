<?php

namespace App\Controller\Admin;

use App\Entity\Ergonomics;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ErgonomicsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ergonomics::class;
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
