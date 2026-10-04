<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterventionController;
Route::redirect('/', '/interventions');
Route::get('/interventions', [InterventionController::class, 'index'])->name('interventions.index');
Route::get('/interventions/{id}', [InterventionController::class, 'show'])->whereNumber('id')->name('interventions.show');
