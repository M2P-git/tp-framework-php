<?php

namespace Tests\Feature;

use App\Models\Intervention;
use App\Models\Machine;
use Tests\TestCase;

// Séance 4 : une factory prépare, dans un test, la donnée dont le test a besoin.
class FactoryTest extends TestCase
{
    public function test_une_intervention_fabriquee_apparait_dans_la_liste(): void
    {
        $a12 = Machine::firstWhere('serie', 'A12');

        Intervention::factory()->for($a12)->create([
            'description' => 'Ventilateur bruyant',
            'statut' => 'recu',
        ]);

        $this->get('/interventions')->assertOk()->assertSee('Ventilateur bruyant');
    }
}
