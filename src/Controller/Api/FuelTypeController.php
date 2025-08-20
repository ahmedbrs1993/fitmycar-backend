<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\FuelTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for managing Fuel Type entities.
 */
final class FuelTypeController extends AbstractController
{
    #[Route('/api/fuel-types/{generationId}', name: 'fuel_types_by_generation', methods: ['GET'])]
    public function getFuelTypesByGeneration(int $generationId, FuelTypeRepository $fuelTypeRepository): JsonResponse
    {
        $fuelTypes = $fuelTypeRepository->findBy(['generation' => $generationId]);

        $data = [];
        foreach ($fuelTypes as $fuelType) {
            $data[] = [
                'id' => $fuelType->getId(),
                'fuel' => $fuelType->getFuel()->getType(),
                'model' => $fuelType->getModelName(),
                'brand' => $fuelType->getBrandName(),
                'generation' => $fuelType->getGeneration()->getName(),
            ];
        }

        return $this->json($data);
    }
}
