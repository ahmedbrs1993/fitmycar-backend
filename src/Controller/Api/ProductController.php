<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\ProductCompatibilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for managing Product entities.
 */
final class ProductController extends AbstractController
{
    #[Route('/api/products/{fuelTypeId}/{category}', name: 'products_by_fueltype_and_category', methods: ['GET'])]
    public function getProductsByFuelTypeAndCategory(
        int $fuelTypeId,
        string $category,
        ProductCompatibilityRepository $productCompatibilityRepository,
    ): JsonResponse {
        $compatibilities = $productCompatibilityRepository->findByFuelTypeAndCategory($fuelTypeId, $category);

        $products = [];

        foreach ($compatibilities as $compatibility) {
            $product = $compatibility->getProduct();
            $products[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'brand' => $product->getBrand(),
                'image' => $product->getImage(),
                'price' => $product->getPrice(),
                'category' => $product->getCategory(),
                'specs' => $product->getSpecs(),
            ];
        }

        return $this->json($products);
    }
}
