<?php

namespace App\Providers;

use App\Services\CatalogueInterventions;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // TODO (point 3) : la liaison de la séance 2 lit encore config/atelier.php.
        // Donnez au service les interventions de la base, sous la même forme
        // (des tableaux avec id, serie, description, statut), en chargeant les machines avec with().
        $this->app->singleton(CatalogueInterventions::class, fn () => new CatalogueInterventions(
            config('atelier.interventions'),
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
