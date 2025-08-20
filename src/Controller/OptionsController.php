<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OptionsController
{
    #[Route('/{path}', name: 'options', requirements: ['path' => '.+'], methods: ['OPTIONS'])]
    public function options(): Response
    {
        return new Response('', 204);
    }
}
