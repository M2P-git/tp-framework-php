<?php

declare(strict_types=1);

/** Échappe un texte avant de l'écrire dans du HTML (équivalent de {{ }} en Blade et Twig). */
function e(string|int|null $texte): string
{
    // TODO point de contrôle 3 : ce texte peut venir d'un visiteur. Il ne doit jamais devenir du HTML.
    //      Piste : htmlspecialchars((string) $texte, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').
    return (string) $texte;
}

/** Exécute templates/<nom>.php avec ces variables et renvoie le HTML produit. */
function vue(string $nom, array $donnees = []): string
{
    extract($donnees, EXTR_SKIP);

    ob_start();
    require __DIR__ . '/../templates/' . $nom . '.php';

    return (string) ob_get_clean();
}
