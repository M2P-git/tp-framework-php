<?php

declare(strict_types=1);

namespace Mini\Http;

/** Le routeur : une table « modèle d'URL -> fonction à appeler ». */
final class Router
{
    /** @var array<string, callable> modèle d'URL => action */
    private array $routes = [];

    public function get(string $modele, callable $action): void
    {
        // TODO point de contrôle 1 : mémoriser la route dans $this->routes (modèle => action).
    }

    public function repartir(Request $requete): Response
    {
        // TODO point de contrôle 1 : parcourir $this->routes ; si le chemin de la requête
        //      est égal au modèle d'une route, appeler son action et renvoyer sa réponse.
        // TODO point de contrôle 4 : accepter les modèles comme /interventions/{id}.
        //      Pistes : preg_replace pour fabriquer l'expression régulière, preg_match pour
        //      comparer, array_filter(..., ARRAY_FILTER_USE_KEY) pour garder les captures nommées,
        //      puis $action(...$parametres) : les clés textuelles deviennent des arguments nommés.

        return new Response('<h1>404 : page introuvable</h1>', 404);
    }
}
