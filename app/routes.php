<?php

declare(strict_types=1);

use App\InterventionController;
use Mini\Http\Response;
use Mini\Http\Router;

// Comparez avec routes/web.php (Laravel) et #[Route] (Symfony).
return function (Router $routeur, InterventionController $interventions): void {
    $routeur->get('/', fn () => new Response('', 302, ['Location' => '/interventions']));
    $routeur->get('/interventions', fn () => $interventions->liste());
    $routeur->get('/interventions/{id}', fn (string $id) => $interventions->detail($id));
};
