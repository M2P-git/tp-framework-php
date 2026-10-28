<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\MachineController;
Route::redirect('/', '/interventions');
Route::get('/interventions', [InterventionController::class, 'index'])->name('interventions.index');
Route::get('/interventions/{id}', [InterventionController::class, 'show'])->whereNumber('id')->name('interventions.show');
// TODO (point 4) : la route GET /machines/{machine:serie}, nommée machines.show,
// vers MachineController::show. {machine:serie} : Laravel cherche la machine par sa série.
