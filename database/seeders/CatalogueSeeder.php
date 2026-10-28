<?php

namespace Database\Seeders;

use App\Models\Piece;
use Illuminate\Database\Seeder;

/**
 * Pour une application déjà en service : ajoute des pièces au catalogue sans rien effacer.
 * On peut le relancer autant de fois qu'on veut : firstOrCreate ne crée que ce qui manque.
 * php artisan db:seed --class=CatalogueSeeder
 */
class CatalogueSeeder extends Seeder
{
    public function run(): void
    {
        $pieces = ['Batterie 45 Wh', 'Clavier AZERTY', 'Chargeur 65 W'];
        foreach ($pieces as $nom) {
            Piece::firstOrCreate(['nom' => $nom]);
        }
    }
}
