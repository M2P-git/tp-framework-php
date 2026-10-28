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
        // Cette fonction indique à Laravel comment construire le service CatalogueInterventions,
        // qui fournit les interventions au contrôleur : elle les lit dans la base, sous forme de tableaux.
        // TODO (point 3) : pour afficher la série, $i->machine déclenche une requête par intervention.
        // Chargez les machines avec les interventions : remplacez Intervention::all() par with('machine')->get().
        $this->app->singleton(CatalogueInterventions::class, fn () => new CatalogueInterventions(
            Intervention::all()->map(fn (Intervention $i) => [
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
