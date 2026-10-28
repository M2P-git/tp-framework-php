<?php
namespace Tests\Feature;

use App\Models\Machine;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

// Point 3 : la liste des interventions vient de la base, et non plus de config/atelier.php.
class ListeDepuisLaBaseTest extends TestCase {
    public function test_une_intervention_ajoutee_en_base_apparait(): void {
        Machine::where('serie', 'B07')->firstOrFail()
            ->interventions()->create(['description' => 'Ecran fissure', 'statut' => 'recu']);

        $this->get('/interventions')->assertOk()->assertSee('Ecran fissure');
    }

    public function test_pas_de_requete_par_intervention(): void {
        DB::enableQueryLog();
        $this->get('/interventions')->assertOk();
        // with('machine') : une requête pour les interventions, une pour leurs machines.
        $this->assertLessThanOrEqual(2, count(DB::getQueryLog()));
    }
}
