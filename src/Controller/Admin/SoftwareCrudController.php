<?php

namespace App\Controller\Admin;

use App\Entity\Software;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SoftwareCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Software::class;
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
