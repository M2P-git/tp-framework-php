@extends('layout')

@section('contenu')
<h1>Connexion</h1>
<form method="post" action="{{ route('connexion') }}">
    @csrf
    <label>Adresse e-mail
        <input name="email" type="email" value="{{ old('email') }}"></label>
    <label>Mot de passe
        <input name="password" type="password"></label>
    @error('email')<p class="erreur">{{ $message }}</p>@enderror
    <button>Se connecter</button>
</form>
@endsection
