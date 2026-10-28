@extends('layout')
@section('contenu')
<h1>Machine {{ $machine->serie }}</h1>
<p>{{ $machine->marque }}, confiée par {{ $machine->personne->nom }}.</p>
<h2>Historique des interventions</h2>
<ol>
{{-- TODO (point 4) : une ligne <li> par intervention de la machine, avec la date du dépôt
     ($intervention->created_at->format('d/m/Y')), la description, le statut,
     et les noms des pièces s'il y en a. --}}
</ol>
@endsection
