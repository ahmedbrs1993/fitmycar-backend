<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Generator;

final class ProductFixtures extends Fixture implements OrderedFixtureInterface
{
    public function getOrder(): int
    {
        return 1;
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getProducts() as [$type, $item]) {
            $product = new Product();
            $product->setName($item['name']);
            $product->setBrand($item['brand']);
            $product->setPrice($item['price']);
            $product->setImage($item['image']);
            $product->setSpecs($item['specs']);
            $product->setCategory($type);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function getProducts(): Generator
    {
        yield ['balais', [
            'name' => 'Balai Premium Aérodynamique',
            'brand' => 'Bosch',
            'price' => 24.99,
            'image' => 'balai1.jpg',
            'specs' => ['Longueur: 60cm', 'Universal Fit', 'Cadre en acier'],
        ]];

        yield ['balais', [
            'name' => 'Balai Silicone Confort+',
            'brand' => 'Valeo',
            'price' => 19.99,
            'image' => 'balai2.jpg',
            'specs' => ['Silicone haute qualité', 'Montage facile', 'Garantie 2 ans'],
        ]];

        yield ['eclairage', [
            'name' => 'Ampoule H7 Vision+',
            'brand' => 'Philips',
            'price' => 14.99,
            'image' => 'light1.jpg',
            'specs' => ['200% plus lumineux', 'Durée de vie longue', 'Blanc pur 6000K'],
        ]];

        yield ['eclairage', [
            'name' => 'Feu arrière LED Dynamo',
            'brand' => 'Osram',
            'price' => 39.99,
            'image' => 'light2.jpg',
            'specs' => ['LED haute puissance', 'Résistant à l\'eau', 'Installation plug-and-play'],
        ]];

        yield ['batteries', [
            'name' => 'Batterie 12V Silver Dynamic',
            'brand' => 'Varta',
            'price' => 89.99,
            'image' => 'battery1.jpg',
            'specs' => ['70Ah', '650A', 'Technologie AGM'],
        ]];

        yield ['batteries', [
            'name' => 'Batterie Stop-Start Energy',
            'brand' => 'Bosch',
            'price' => 129.99,
            'image' => 'battery2.jpg',
            'specs' => ['74Ah', '680A', 'Pour véhicules Start-Stop'],
        ]];

        yield ['huiles-moteur', [
            'name' => 'Huile Synthétique 5W-30',
            'brand' => 'Total',
            'price' => 34.99,
            'image' => 'oil1.jpg',
            'specs' => ['5L', 'Norme ACEA C3', 'Prolonge la durée de vie du moteur'],
        ]];

        yield ['huiles-moteur', [
            'name' => 'Huile Moteur Haute Performance',
            'brand' => 'Mobil',
            'price' => 49.99,
            'image' => 'oil2.jpg',
            'specs' => ['0W-20', 'Full synthétique', 'Réduction de la consommation'],
        ]];

        yield ['filtres', [
            'name' => 'Filtre à air Premium',
            'brand' => 'Mann-Filter',
            'price' => 18.99,
            'image' => 'filter1.jpg',
            'specs' => ['Haute filtration', 'Débit d\'air optimal', 'Matériaux durables'],
        ]];

        yield ['filtres', [
            'name' => 'Filtre à huile LongLife',
            'brand' => 'Hengst',
            'price' => 12.99,
            'image' => 'filter2.jpg',
            'specs' => ['Efficacité 99%', 'Valve anti-refoulement', 'Joint intégré'],
        ]];

        yield ['lave-glaces', [
            'name' => 'Liquide lave-glace Concentré',
            'brand' => 'Prestone',
            'price' => 6.99,
            'image' => 'washer1.jpg',
            'specs' => ['-30°C protection', '5L', 'Dégivrage rapide'],
        ]];

        yield ['lave-glaces', [
            'name' => 'Additif Nettoyant Pare-brise',
            'brand' => 'Sonax',
            'price' => 8.99,
            'image' => 'washer2.jpg',
            'specs' => ['Effet anti-buée', 'Protection pluie', 'Formule biodégradable'],
        ]];

        yield ['liquide-refroidissement', [
            'name' => 'Antigel G12++',
            'brand' => 'Glysantin',
            'price' => 14.99,
            'image' => 'coolant1.jpg',
            'specs' => ['Prémélangé', 'Protection -37°C', 'Compatible aluminium'],
        ]];

        yield ['liquide-refroidissement', [
            'name' => 'Liquide Refroidissement Long Life',
            'brand' => 'Motul',
            'price' => 16.99,
            'image' => 'coolant2.jpg',
            'specs' => ['5L', 'Technologie OAT', 'Sans silicate'],
        ]];
    }
}
