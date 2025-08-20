<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\FuelType;
use App\Entity\Product;
use App\Entity\ProductCompatibility;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class CompatibilityFixtures extends Fixture implements OrderedFixtureInterface
{
    public function getOrder(): int
    {
        return 3;
    }

    public function load(ObjectManager $manager): void
    {
        $productRepo = $manager->getRepository(Product::class);
        $fuelTypeRepo = $manager->getRepository(FuelType::class);

        $allProducts = $productRepo->findAll();
        $allFuelTypes = $fuelTypeRepo->findAll();

        foreach ($allProducts as $product) {
            $randomFuelTypes = (array) array_rand($allFuelTypes, 3);

            foreach ($randomFuelTypes as $index) {
                $compat = new ProductCompatibility();
                $compat->setProduct($product);
                $compat->setFuelType($allFuelTypes[$index]);
                $manager->persist($compat);
            }
        }

        $manager->flush();
    }
}
