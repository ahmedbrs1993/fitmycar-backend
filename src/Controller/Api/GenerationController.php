<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\GenerationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for managing Generation entities.
 */
final class GenerationController extends AbstractController
{
    #[Route('/api/generations/{modelId}', name: 'generations_by_model', methods: ['GET'])]
    public function getGenerationsByModel(int $modelId, GenerationRepository $generationRepository): JsonResponse
    {
        $generations = $generationRepository->findBy(['model' => $modelId]);

        $data = [];
        foreach ($generations as $generation) {
            $data[] = [
                'id' => $generation->getId(),
                'name' => $generation->getName(),
            ];
        }

        return $this->json($data);
    }
}
