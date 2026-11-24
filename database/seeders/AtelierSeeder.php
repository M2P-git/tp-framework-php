<?php

namespace Database\Seeders;

use App\Models\Personne;
use App\Models\Piece;
use Illuminate\Database\Seeder;

class AtelierSeeder extends Seeder
{
    public function run(): void
    {
        $nadia = Personne::create(['nom' => 'Nadia', 'telephone' => '0600000001']);
        $karim = Personne::create(['nom' => 'Karim', 'telephone' => '0600000002']);

        $a12 = $nadia->machines()->create(['serie' => 'A12', 'marque' => 'Lenovo']);
        $c19 = $nadia->machines()->create(['serie' => 'C19', 'marque' => 'HP']);
        $b07 = $karim->machines()->create(['serie' => 'B07', 'marque' => 'Dell']);

        $ecran = Piece::create(['nom' => 'Ecran 14 pouces']);
        $ssd = Piece::create(['nom' => 'Disque SSD 256 Go']);
        $nappe = Piece::create(['nom' => "Nappe d'écran"]);
        $batterie = Piece::create(['nom' => 'Batterie 45 Wh']);

        $a12->interventions()->create(['description' => 'Disque lent', 'statut' => 'clos'])
            ->pieces()->attach($ssd);
        $a12->interventions()->create(['description' => 'Ecran noir', 'statut' => 'recu'])
            ->pieces()->attach([$ecran->id, $nappe->id]);
        $c19->interventions()->create(['description' => 'Disque plein', 'statut' => 'clos'])
            ->pieces()->attach($ssd);
        $b07->interventions()->create(['description' => 'Batterie faible', 'statut' => 'clos'])
            ->pieces()->attach($batterie);
        $c19->interventions()->create(['description' => 'Clavier bloque', 'statut' => 'en_cours']);
    }
}
