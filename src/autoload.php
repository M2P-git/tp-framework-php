<?php

declare(strict_types=1);

// L'autoloader : PHP l'appelle quand il rencontre une classe inconnue.
// Mini\Http\Router  ->  src/Http/Router.php
// App\InterventionController  ->  app/InterventionController.php
// C'est, en miniature, ce que fait Composer (vendor/autoload.php, norme PSR-4).
spl_autoload_register(function (string $classe): void {
    $dossiers = [
        'Mini\\' => __DIR__ . '/',
        'App\\' => __DIR__ . '/../app/',
    ];

    foreach ($dossiers as $prefixe => $dossier) {
        if (str_starts_with($classe, $prefixe)) {
            $relatif = substr($classe, strlen($prefixe));
            $fichier = $dossier . str_replace('\\', '/', $relatif) . '.php';
            if (is_file($fichier)) {
                require $fichier;
            }
        }
    }
});

// Les fonctions ne s'autochargent pas : on charge ce fichier d'aides à la main.
// Composer fait de même pour view(), route()... de Laravel (clé "autoload.files").
require __DIR__ . '/vue.php';
