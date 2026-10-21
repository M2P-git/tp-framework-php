<?php
namespace Tests\Unit;

use App\Services\CatalogueInterventions;
use PHPUnit\Framework\TestCase;

// Le service, testé SEUL : pas de serveur, pas de requête, pas de conteneur.
// On le construit nous-mêmes avec des données choisies pour le test.
class CatalogueInterventionsTest extends TestCase {
    private function catalogue(): CatalogueInterventions {
        return new CatalogueInterventions([
            ['id' => 1, 'serie' => 'T01', 'description' => 'Ecran fissure', 'statut' => 'recu'],
            ['id' => 2, 'serie' => 'T02', 'description' => 'Ecran noir', 'statut' => 'clos'],
            ['id' => 3, 'serie' => 'T03', 'description' => 'Ventilateur bruyant', 'statut' => 'en_cours'],
        ]);
    }

    public function test_ouvertes_exclut_les_clos(): void {
        $this->assertSame(['T01', 'T03'], array_column($this->catalogue()->ouvertes(), 'serie'));
    }

    public function test_sans_mot_rend_les_ouvertes(): void {
        $this->assertCount(2, $this->catalogue()->chercher(null));
        $this->assertCount(2, $this->catalogue()->chercher('   '));
    }

    public function test_casse_et_espaces_ignores(): void {
        $this->assertSame(['T01'], array_column($this->catalogue()->chercher('  ECRAN  '), 'serie'));
    }

    public function test_mot_absent(): void {
        $this->assertSame([], $this->catalogue()->chercher('imprimante'));
    }

    // TODO (point 4) : écrivez test_un_dossier_clos_ne_revient_jamais.
    // Cherchez un mot qui n'apparaît QUE dans une intervention close.
}
