<?php

declare(strict_types=1);

namespace Mini\Http;

/** La requête reçue, sous forme d'objet (Symfony : Request ; Laravel en hérite). */
final class Request
{
    public function __construct(
        public readonly string $methode,
        public readonly string $chemin,
        public readonly array $requete = [],
    ) {}

    /** Construit l'objet à partir des superglobales de PHP. */
    public static function depuisGlobales(): self
    {
        return new self(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/',
            $_GET,
        );
    }
}
