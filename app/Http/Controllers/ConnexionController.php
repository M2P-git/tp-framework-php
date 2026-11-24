<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

// Fourni à la séance 4 : la connexion la plus simple, avec le garde « web » (la session).
// Utilisateur de démonstration, créé par DatabaseSeeder : test@example.com, mot de passe « password ».
class ConnexionController extends Controller
{
    public function formulaire(): View
    {
        return view('connexion');
    }

    public function connecter(Request $request): RedirectResponse
    {
        $identifiants = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($identifiants)) {
            $request->session()->regenerate();

            return redirect()->intended(route('atelier'));
        }

        return back()->withErrors(['email' => 'Adresse ou mot de passe incorrect.'])->onlyInput('email');
    }

    public function deconnecter(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('interventions.index');
    }
}
