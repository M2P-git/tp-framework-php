@extends('layout')
@section('contenu')
<h1>Intervention {{ $intervention['id'] }}</h1>
<p>Machine {{ $intervention['serie'] }} : {{ $intervention['description'] }}</p>
@endsection
