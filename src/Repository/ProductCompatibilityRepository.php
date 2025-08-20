<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductCompatibility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductCompatibility>
 */
final class ProductCompatibilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductCompatibility::class);
    }

    /**
     * @return ProductCompatibility[]
     */
    public function findByFuelTypeAndCategory(int $fuelTypeId, string $category): array
    {
        return $this
            ->createQueryBuilder('pc')
            ->join('pc.product', 'p')
            ->andWhere('pc.fuelType = :fuelTypeId')
            ->andWhere('p.category = :category')
            ->setParameter('fuelTypeId', $fuelTypeId)
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }
}
