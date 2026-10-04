<?php
declare(strict_types=1);
namespace App\Http\Controllers;
use App\Services\CatalogueInterventions;
use Illuminate\Http\Request;
use Illuminate\View\View;
final class InterventionController extends Controller {
    public function __construct(private CatalogueInterventions $catalogue) {}
    public function index(Request $request): View {
        $mot = $request->query('q');
        abort_if($mot !== null && !is_string($mot), 400, 'Recherche invalide');
        return view('interventions.index', [
            'interventions'=>$this->catalogue->chercher($mot), 'mot'=>$mot ?? '',
        ]);
    }
    public function show(int $id): View {
        $intervention=$this->catalogue->trouver($id);
        abort_if($intervention === null, 404);
        return view('interventions.show', compact('intervention'));
    }
}
