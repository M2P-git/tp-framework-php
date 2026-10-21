<?php
namespace Tests\Feature;

use App\Services\CatalogueInterventions;
use Tests\TestCase;

// Remplacer un service pour un test : on DONNE au conteneur l'objet à utiliser.
// Le contrôleur ne voit pas la différence : il reçoit un CatalogueInterventions.
class RemplacementTest extends TestCase {
    public function test_le_controleur_utilise_le_service_du_conteneur(): void {
        $this->app->instance(CatalogueInterventions::class, new CatalogueInterventions([
            ['id' => 900, 'serie' => 'Z99', 'description' => 'Imprimante muette', 'statut' => 'recu'],
        ]));

        $this->get('/interventions')->assertOk()->assertSee('Z99')->assertDontSee('A12');
    }
}
