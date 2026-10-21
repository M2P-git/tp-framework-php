<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // TODO (point 2) : apprendre au conteneur à construire CatalogueInterventions.
        // Son constructeur demande un tableau : le conteneur ne peut pas le deviner.
        // Donnez-lui une fonction qui crée le service avec config('atelier.interventions').
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
