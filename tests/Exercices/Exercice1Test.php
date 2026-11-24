<?php

namespace Tests\Exercices;

use App\Models\Intervention;
use App\Models\Machine;
use App\Models\Personne;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

// Séance 4, exercice 1 : les pages des personnes.
// Lancer : php artisan test tests/Exercices/Exercice1Test.php
// Les données sont celles d'AtelierSeeder : Nadia (id 1 : A12, C19) et Karim (id 2 : B07).
class Exercice1Test extends TestCase
{
    public function test_la_liste_des_personnes_par_ordre_alphabetique(): void
    {
        $this->get('/personnes')->assertOk()
            ->assertViewIs('personnes.index')
            ->assertSeeInOrder(['Karim', 'Nadia']);
    }

    public function test_la_liste_compte_les_machines_dans_la_requete(): void
    {
        $this->get('/personnes')->assertViewHas('personnes', function ($personnes) {
            return (int) $personnes->firstWhere('nom', 'Nadia')->machines_count === 2;
        });
    }

    public function test_la_fiche_de_nadia(): void
    {
        $this->get('/personnes/1')->assertOk()
            ->assertViewIs('personnes.show')
            ->assertSeeInOrder(['Nadia', 'A12', 'Disque lent', 'C19', 'Clavier bloque']);
    }

    public function test_la_fiche_charge_les_relations_sans_une_requete_par_machine(): void
    {
        // Une personne fabriquée avec 5 machines de 2 interventions : avec load('machines.interventions'),
        // la page demande 3 requêtes ; sans load(), Blade va chercher les interventions machine par machine.
        $personne = Personne::factory()
            ->has(Machine::factory(5)->has(Intervention::factory(2)))
            ->create();

        DB::enableQueryLog();
        $this->get('/personnes/' . $personne->id)->assertOk();

        $this->assertLessThanOrEqual(3, count(DB::getQueryLog()), 'Trop de requêtes : utilisez load() dans show().');
    }

    public function test_une_personne_inconnue_donne_404(): void
    {
        $this->get('/personnes/99')->assertNotFound();
    }
}
