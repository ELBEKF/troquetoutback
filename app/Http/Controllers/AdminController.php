<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\offers;

class AdminController extends Controller
{
    /**
     * Afficher le tableau de bord de l'administrateur.
     */
    public function dashboard()
    {
        // Vérifie que l'utilisateur est admin
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Accès refusé.');
        }

        // Récupération des données
        $users = Users::all();
        $offers = offers::all();

        // Calcul des statistiques
        $stats = [
            'total_users' => $users->count(),
            'total_offers' => $offers->count(),
        ];

        // Retourne une vue Blade ou une réponse JSON
        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'users' => $users,
            'offers' => $offers,
            'stats' => $stats,
        ]);
    }

    /**
     * Supprimer un utilisateur par son ID.
     */
    public function deleteUser($id)
    {
        $admin = Auth::user();

        if ($admin->role !== 'admin') {
            return redirect('/')->with('error', 'Accès refusé.');
        }

        if ($admin->id == $id) {
            return redirect('/admin')->with('error', "Vous ne pouvez pas supprimer votre propre compte administrateur.");
        }

        $user = Users::findOrFail($id);
        $user->delete();

        return redirect('/admin')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Supprimer une offre.
     */
    public function deleteOffer($id)
    {
        $admin = Auth::user();

        if ($admin->role !== 'admin') {
            return redirect('/')->with('error', 'Accès refusé.');
        }

        $offer = Offers::findOrFail($id);
        $offer->delete();

        return redirect('/admin')->with('success', 'Offre supprimée avec succès.');
    }

    /**
     * Mettre à jour un utilisateur (admin uniquement).
     */
    public function updateUser(Request $request, $id)
    {
        $admin = Auth::user();

        if ($admin->role !== 'admin') {
            return response()->json(['error' => 'Accès refusé.'], 403);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:100',
            'code_postal' => 'nullable|string|max:10',
        ]);

        $user = Users::findOrFail($id);
        $user->update($validated);

        return redirect('/admin')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Récupérer les détails d’un utilisateur (facultatif, pour affichage ou édition).
     */
    public function getUserById($id)
    {
        $admin = Auth::user();

        if ($admin->role !== 'admin') {
            return response()->json(['error' => 'Accès refusé.'], 403);
        }

        $user = Users::findOrFail($id);

        return response()->json(['success' => true, 'data' => $user]);
    }
}
