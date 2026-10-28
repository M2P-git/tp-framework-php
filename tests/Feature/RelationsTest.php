<?php
namespace Tests\Feature;

use App\Models\Intervention;
use App\Models\Machine;
use App\Models\Piece;
use Tests\TestCase;

// Point 1 : les relations entre modèles. La base est remplie par DatabaseSeeder (voir tests/TestCase.php).
class RelationsTest extends TestCase {
    public function test_une_machine_connait_ses_interventions(): void {
        $a12 = Machine::where('serie', 'A12')->firstOrFail();
        $this->assertSame(['Disque lent', 'Ecran noir'], $a12->interventions->pluck('description')->all());
    }

    public function test_une_intervention_connait_sa_machine_et_sa_personne(): void {
        $intervention = Intervention::where('description', 'Ecran noir')->firstOrFail();
        $this->assertSame('A12', $intervention->machine->serie);
        $this->assertSame('Nadia', $intervention->machine->personne->nom);
    }

    public function test_une_piece_sert_dans_plusieurs_interventions(): void {
        $ssd = Piece::where('nom', 'Disque SSD 256 Go')->firstOrFail();
        $this->assertSame(['Disque lent', 'Disque plein'], $ssd->interventions->pluck('description')->all());
    }
}
