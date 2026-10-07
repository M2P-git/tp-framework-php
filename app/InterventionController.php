<?php

declare(strict_types=1);

namespace App;

use Mini\Http\Response;

final class InterventionController
{
    /** Les interventions arrivent par le constructeur : c'est le principe de l'injection de dépendances. */
    public function __construct(private array $interventions) {}

    public function liste(): Response
    {
        // TODO point de contrôle 2 : ne garder que les interventions dont le statut n'est pas « clos ».
        //      Pistes : array_filter, une fonction fléchée fn, la comparaison stricte !==, array_values.
        $ouvertes = $this->interventions;

        return $this->page('Interventions ouvertes', 'liste', ['interventions' => $ouvertes]);
    }

    public function detail(string $id): Response
    {
        // TODO point de contrôle 4 : chercher l'intervention dont l'identifiant vaut $id
        //      (attention : $id est un texte, 'id' dans les données est un entier) et afficher
        //      la vue 'detail'. Sinon, répondre avec la vue '404' et le statut 404.
        return $this->page('Introuvable', '404', [], 404);
    }

    /** Une réponse = un gabarit commun (layout) + une vue particulière. */
    private function page(string $titre, string $vue, array $donnees, int $statut = 200): Response
    {
        return new Response(vue('layout', [
            'titre' => $titre,
            'contenu' => vue($vue, $donnees),
        ]), $statut);
    }
}
