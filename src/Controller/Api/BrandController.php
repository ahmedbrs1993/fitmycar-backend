<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\BrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for managing Brand entities.
 */
final class BrandController extends AbstractController
{
    #[Route('/api/brands', name: 'api_brands', methods: ['GET'])]
    public function getBrands(BrandRepository $brandRepository): JsonResponse
    {
        $brands = $brandRepository->findAll();

        $data = [];
        foreach ($brands as $brand) {
            $data[] = [
                'id' => $brand->getId(),
                'name' => $brand->getName(),
            ];
        }

        return $this->json($data);
    }
}
