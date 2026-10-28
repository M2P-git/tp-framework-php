<?php
declare(strict_types=1);
namespace App\Http\Controllers;
use App\Models\Machine;
use Illuminate\View\View;
final class MachineController extends Controller {
    // Laravel trouve la machine à partir de l'adresse (/machines/A12) : c'est la liaison de route.
    // Une série inconnue donne une page 404, sans code à écrire.
    public function show(Machine $machine): View {
        // TODO (point 4) : chargez la personne et les interventions avec leurs pièces (load),
        // puis renvoyez la vue machines.show avec la machine.
    }
}
