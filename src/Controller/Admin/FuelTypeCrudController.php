<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\FuelType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

/**
 * @extends AbstractCrudController<FuelType>
 */
final class FuelTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FuelType::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Fuel Types')
            ->setPageTitle(Crud::PAGE_NEW, 'Create Fuel Type')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit Fuel Type')
            ->setEntityLabelInSingular('Fuel Type')
            ->setEntityLabelInPlural('Fuel Types')
            ->setSearchFields([
                'name',
                'generation.name',
                'generation.model.name',
                'generation.model.brand.name',
            ]);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::EDIT);
    }

    public function configureFields(string $pageName): iterable
    {
        $generationField = AssociationField::new('generation', 'Brand - Model - Generation')->autocomplete();

        if ($pageName === Crud::PAGE_EDIT) {
            $generationField->setFormTypeOption('disabled', true);
        }

        return [
            IdField::new('id')->hideOnForm(),
            $generationField,
            AssociationField::new('fuel')->autocomplete(),
        ];
    }
}
