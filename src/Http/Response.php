<?php

declare(strict_types=1);

namespace Mini\Http;

/** La réponse à envoyer : un code d'état, des en-têtes, un corps. */
final class Response
{
    public function __construct(
        public readonly string $corps,
        public readonly int $statut = 200,
        public readonly array $entetes = ['Content-Type' => 'text/html; charset=UTF-8'],
    ) {}

    public function envoyer(): void
    {
        http_response_code($this->statut);

        foreach ($this->entetes as $nom => $valeur) {
            header("$nom: $valeur");
        }

        echo $this->corps;
    }
}
