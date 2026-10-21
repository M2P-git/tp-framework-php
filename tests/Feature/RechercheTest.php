<?php
namespace Tests\Feature;
use Tests\TestCase;

// La recherche, vue de l'extérieur : de vraies requêtes HTTP traversent le routeur,
// le contrôleur, le service et la vue Blade.
class RechercheTest extends TestCase {
    public function test_recherche_normalisee(): void {
        $this->get('/interventions?q=%20ECRAN%20')->assertOk()->assertSee('A12')->assertDontSee('C19');
    }
    public function test_recherche_blanche(): void {
        $this->get('/interventions?q=%20%20')->assertOk()->assertSee('A12')->assertSee('C19');
    }
    public function test_resultat_absent(): void {
        $this->get('/interventions?q=imprimante')->assertOk()->assertSee('Aucune intervention');
    }
    public function test_entree_tableau_refusee(): void {
        $this->get('/interventions?q[]=x')->assertStatus(400);
    }
    public function test_saisie_html_echappee(): void {
        $this->get('/interventions?q='.urlencode('<script>alert(1)</script>'))
            ->assertOk()->assertSee('&lt;script&gt;', false)->assertDontSee('<script>', false);
    }
}
