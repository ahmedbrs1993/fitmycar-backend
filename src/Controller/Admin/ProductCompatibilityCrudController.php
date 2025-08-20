<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\ProductCompatibility;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

/**
 * @extends AbstractCrudController<ProductCompatibility>
 */
final class ProductCompatibilityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCompatibility::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('fuelType', 'Vehicle')->autocomplete(),
            AssociationField::new('product')->autocomplete(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Product Compatibility')
            ->setPageTitle(Crud::PAGE_NEW, 'Create Product Compatibility')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit Product Compatibility')
            ->setEntityLabelInSingular('Product Compatibility')
            ->setEntityLabelInPlural('Product Compatibility')
            ->setSearchFields([
                'product.name',
                'fuelType.fuel.type',
                'fuelType.generation.name',
                'fuelType.generation.model.name',
                'fuelType.generation.model.brand.name',
            ]);
    }
}
