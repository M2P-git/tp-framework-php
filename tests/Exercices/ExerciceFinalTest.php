<?php

namespace Tests\Exercices;

use App\Models\Intervention;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

// Séance 4, exercice final : le catalogue des pièces.
// Lancer : php artisan test tests/Exercices/ExerciceFinalTest.php
// Les données sont celles d'AtelierSeeder : 4 pièces, toutes utilisées au moins une fois ;
// Disque SSD 256 Go (id 2) a servi pour « Disque lent » (A12) et « Disque plein » (C19).
class ExerciceFinalTest extends TestCase
{
    private function technicien(): User
    {
        return User::factory()->create();
    }

    public function test_les_pages_sont_reservees_aux_utilisateurs_connectes(): void
    {
        $this->get('/pieces')->assertRedirect('/connexion');
        $this->get('/pieces/2')->assertRedirect('/connexion');
    }

    public function test_la_liste_des_pieces_par_ordre_alphabetique(): void
    {
        $this->actingAs($this->technicien())->get('/pieces')
            ->assertOk()
            ->assertViewIs('pieces.index')
            ->assertSeeInOrder(['Batterie 45 Wh', 'Disque SSD 256 Go', 'Ecran 14 pouces']);
    }

    public function test_la_liste_compte_les_interventions_dans_la_requete(): void
    {
        $this->actingAs($this->technicien())->get('/pieces')
            ->assertViewHas('pieces', function ($pieces) {
                return (int) $pieces->firstWhere('nom', 'Disque SSD 256 Go')->interventions_count === 2;
            });
    }

    public function test_le_service_compte_les_pieces_jamais_utilisees(): void
    {
        Piece::factory()->create();

        $this->actingAs($this->technicien())->get('/pieces')
            ->assertSee('Pièces jamais utilisées : 1');
    }

    public function test_la_fiche_d_une_piece(): void
    {
        $this->actingAs($this->technicien())->get('/pieces/2')
            ->assertOk()
            ->assertViewIs('pieces.show')
            ->assertSeeInOrder(['Disque SSD 256 Go', 'Disque lent', 'A12', 'Disque plein', 'C19']);
    }

    public function test_la_fiche_charge_les_relations_sans_une_requete_par_intervention(): void
    {
        // Une pièce fabriquée, utilisée dans 5 interventions de 5 machines différentes.
        $piece = Piece::factory()->hasAttached(Intervention::factory(5))->create();
        $technicien = $this->technicien();

        DB::enableQueryLog();
        $this->actingAs($technicien)->get('/pieces/' . $piece->id)->assertOk();

        $this->assertLessThanOrEqual(3, count(DB::getQueryLog()), 'Trop de requêtes : utilisez load() dans show().');
    }

    public function test_les_pages_des_pieces_passent_par_le_journal(): void
    {
        $this->actingAs($this->technicien())->get('/pieces')
            ->assertHeader('X-Atelier', 'Solidaire');
    }

    public function test_une_piece_inconnue_donne_404(): void
    {
        $this->actingAs($this->technicien())->get('/pieces/99')->assertNotFound();
    }
}
