@extends('layout')
@section('contenu')
<h1>Interventions ouvertes</h1>
<form method="get"><label>Rechercher une panne <input name="q" value="{{ $mot }}"></label><button>Rechercher</button></form>
<ul>@forelse($interventions as $i)
<li><a href="{{ route('interventions.show', $i['id']) }}">{{ $i['serie'] }}</a> : {{ $i['description'] }} ({{ $i['statut'] }})</li>
@empty<li>Aucune intervention ouverte.</li>@endforelse</ul>
@endsection
