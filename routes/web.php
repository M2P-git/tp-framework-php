<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\InterventionController;

Route::redirect('/', '/interventions');
Route::get('/interventions', [InterventionController::class, 'index'])->name('interventions.index');
Route::get('/interventions/{id}', [InterventionController::class, 'show'])->whereNumber('id')->name('interventions.show');

// Fourni pour la séance 4 : la connexion (partie « Guards »). La page de connexion s'appelle « login » :
// c'est le nom que le middleware auth utilise pour y renvoyer un visiteur qui n'est pas connecté.
Route::get('/connexion', [ConnexionController::class, 'formulaire'])->name('login');
Route::post('/connexion', [ConnexionController::class, 'connecter'])->name('connexion');
Route::post('/deconnexion', [ConnexionController::class, 'deconnecter'])->name('deconnexion');

// Séance 4 : les routes des contrôleurs que nous allons créer s'ajoutent ici.
