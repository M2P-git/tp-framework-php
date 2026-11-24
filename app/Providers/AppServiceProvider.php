<?php

namespace App\Providers;

use App\Models\Intervention;
use App\Services\CatalogueInterventions;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Séance 2 : le service recevait config('atelier.interventions').
        // Séance 3 : il reçoit les interventions de la base, sous la même forme (des tableaux).
        // Le service, le contrôleur et les vues ne changent pas.
        // with('machine') charge toutes les machines en une seule requête (sinon : une requête par intervention).
        $this->app->singleton(CatalogueInterventions::class, fn () => new CatalogueInterventions(
            Intervention::with('machine')->get()->map(fn (Intervention $i) => [
                'id' => $i->id,
                'serie' => $i->machine->serie,
                'description' => $i->description,
                'statut' => $i->statut,
            ])->all(),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
