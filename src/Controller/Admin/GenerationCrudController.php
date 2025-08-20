<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Generation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/**
 * @extends AbstractCrudController<Generation>
 */
final class GenerationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Generation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Generations')
            ->setSearchFields(['name', 'model.name', 'model.brand.name']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('model', 'Brand - Model')
                ->autocomplete()
                ->setFormTypeOption('disabled', $pageName === Crud::PAGE_EDIT),
            TextField::new('name', 'Generation'),
        ];
    }
}
