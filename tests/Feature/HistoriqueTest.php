<?php
namespace Tests\Feature;

use App\Models\Machine;
use Tests\TestCase;

// Point 4 : la page « historique d'une machine », et la règle de la séance 3 :
// une machine qui revient crée une nouvelle intervention, jamais une nouvelle machine.
class HistoriqueTest extends TestCase {
    public function test_l_historique_de_a12(): void {
        $this->get('/machines/A12')->assertOk()
            ->assertSee('Nadia')
            ->assertSeeInOrder(['Disque lent', 'Ecran noir'])
            ->assertSee("Nappe d'écran");
    }

    public function test_une_machine_inconnue_donne_404(): void {
        $this->get('/machines/Z99')->assertNotFound();
    }

    public function test_la_liste_mene_a_l_historique(): void {
        $this->get('/interventions')->assertOk()->assertSee('/machines/A12', false);
    }

    public function test_un_retour_ne_cree_pas_de_machine(): void {
        $a12 = Machine::where('serie', 'A12')->firstOrFail();
        $a12->interventions()->create(['description' => 'Ventilateur bruyant', 'statut' => 'recu']);

        $this->assertSame(3, Machine::count());
        $this->assertSame(3, $a12->interventions()->count());
        $this->get('/machines/A12')->assertOk()->assertSeeInOrder(['Disque lent', 'Ecran noir', 'Ventilateur bruyant']);
    }
}
