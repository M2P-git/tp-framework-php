<?php
declare(strict_types=1);
namespace App\Services;

/**
 * Les règles de l'atelier sur les interventions. Le service ne sait pas d'où viennent
 * les données : on les lui DONNE en le construisant (config, base de données, ou un test).
 */
final class CatalogueInterventions {
    /** @param list<array{id: int, serie: string, description: string, statut: string}> $interventions */
    public function __construct(private readonly array $interventions) {}

    public function toutes(): array {
        return $this->interventions;
    }

    public function ouvertes(): array {
        return array_values(array_filter($this->interventions,
            fn(array $i): bool => $i['statut'] !== 'clos'));
    }

    public function chercher(?string $mot): array {
        $mot = mb_strtolower(trim($mot ?? ''));
        if ($mot === '') { return $this->ouvertes(); }
        return array_values(array_filter($this->ouvertes(),
            fn(array $i): bool => str_contains(mb_strtolower($i['description']), $mot)));
    }

    public function trouver(int $id): ?array {
        foreach ($this->interventions as $i) { if ($i['id'] === $id) { return $i; } }
        return null;
    }
}
