<?php
declare(strict_types=1);
namespace App\Services;
final class CatalogueInterventions {
    public function toutes(): array {
        return [
            ['id'=>101,'serie'=>'A12','description'=>'Ecran noir','statut'=>'recu'],
            ['id'=>102,'serie'=>'B07','description'=>'Batterie faible','statut'=>'clos'],
            ['id'=>103,'serie'=>'C19','description'=>'Clavier bloque','statut'=>'en_cours'],
        ];
    }
    public function ouvertes(): array {
        // TODO : conserver seulement les interventions ouvertes.
        return $this->toutes();
    }
    public function chercher(?string $mot): array {
        $mot = strtolower(trim($mot ?? ''));
        if ($mot === '') { return $this->ouvertes(); }
        return array_values(array_filter($this->ouvertes(),
            fn(array $i): bool => str_contains(strtolower($i['description']), $mot)));
    }
    public function trouver(int $id): ?array {
        foreach ($this->toutes() as $i) { if ($i['id'] === $id) { return $i; } }
        return null;
    }
}
