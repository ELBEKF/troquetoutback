<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $error = '';

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'telephone' => 'nullable|string|max:20',
                'ville' => 'nullable|string|max:255',
                'code_postal' => 'nullable|string|max:10',
            ]);
            $user = Users::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'telephone' => $validated['telephone'] ?? null,
                'ville' => $validated['ville'] ?? null,
                'code_postal' => $validated['code_postal'] ?? null,
                'role' => 'utilisateur',
            ]);


            return redirect('/connexion')->with('success', 'Inscription réussie, vous pouvez maintenant vous connecter.');
        }

        return view('inscription', [
            'title' => 'Inscription',
            'error' => $error
        ]);
    }


    public function profil()
    {
        if (!Auth::check()) {
            return redirect('/connexion');
        }

        $profil = Auth::user();

        return view('profil', [
            'title' => 'Mon profil',
            'profil' => $profil
        ]);
    }


    public function modifProfil()
    {
        if (!Auth::check()) {
            return redirect('/connexion');
        }

        $user = Auth::user();

        return view('modifProfil', [
            'title' => 'Modifier mon profil',
            'user' => $user,
            'error' => ''
        ]);
    }


    public function updateProfil(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/connexion');
        }

        $user = Auth::user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:10',
        ]);

        $user->update($validated);

        return redirect('/profil')->with('success', 'Profil mis à jour avec succès.');
    }
}
