<?php
namespace Tests\Feature;

use App\Models\Machine;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

// Point 2 : les données de démonstration de l'atelier (database/seeders/AtelierSeeder.php).
class SeederTest extends TestCase {
    public function test_les_lignes_de_demonstration(): void {
        $this->assertSame(2, DB::table('personnes')->count());
        $this->assertSame(3, DB::table('machines')->count());
        $this->assertSame(5, DB::table('interventions')->count());
        $this->assertSame(4, DB::table('pieces')->count());
        $this->assertSame(5, DB::table('intervention_piece')->count());
    }

    public function test_l_historique_de_c19_et_de_b07(): void {
        $c19 = Machine::where('serie', 'C19')->firstOrFail();
        $this->assertSame(['Disque plein', 'Clavier bloque'], $c19->interventions->pluck('description')->all());
        $this->assertSame(['clos', 'en_cours'], $c19->interventions->pluck('statut')->all());
        $b07 = Machine::where('serie', 'B07')->firstOrFail();
        $this->assertSame('Karim', $b07->personne->nom);
        $this->assertSame(['Batterie 45 Wh'], $b07->interventions->first()->pieces->pluck('nom')->all());
    }
}
