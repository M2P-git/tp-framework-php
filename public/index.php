<?php

declare(strict_types=1);

use App\InterventionController;
use Mini\Http\Request;
use Mini\Http\Router;

require __DIR__ . '/../src/autoload.php';                       // 1. l'autoloader

$routeur = new Router();                                         // 2. le routeur
$controleur = new InterventionController(require __DIR__ . '/../app/data.php');
(require __DIR__ . '/../app/routes.php')($routeur, $controleur); // 3. les routes

$routeur->repartir(Request::depuisGlobales())->envoyer();        // 4. répartir, 5. envoyer
