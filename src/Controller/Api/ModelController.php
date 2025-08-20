<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for managing Model entities.
 */
final class ModelController extends AbstractController
{
    #[Route('/api/models/{brandId}', name: 'models_by_brand', methods: ['GET'])]
    public function getModelsByBrand(int $brandId, ModelRepository $modelRepository): JsonResponse
    {
        $models = $modelRepository->findBy(['brand' => $brandId]);

        $data = [];
        foreach ($models as $model) {
            $data[] = [
                'id' => $model->getId(),
                'name' => $model->getName(),
            ];
        }

        return $this->json($data);
    }
}
