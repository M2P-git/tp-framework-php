<?php

// Les interventions de démonstration de l'Atelier Solidaire (données fictives).
// En séance 3, elles viendront de la base de données ; pour l'instant, elles sont ici.
// On les lit avec config('atelier.interventions').
return [
    'interventions' => [
        ['id' => 101, 'serie' => 'A12', 'description' => 'Ecran noir', 'statut' => 'recu'],
        ['id' => 102, 'serie' => 'B07', 'description' => 'Batterie faible', 'statut' => 'clos'],
        ['id' => 103, 'serie' => 'C19', 'description' => 'Clavier bloque', 'statut' => 'en_cours'],
    ],
];
