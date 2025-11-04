<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favoris;

class FavorisController extends Controller
{

    public function getFavoris()
    {
        $userId = Auth::id();

        // On récupère les favoris avec les infos des offres associées
        $favoris = Favoris::with('offer')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $favoris
        ], 200);
    }

    /**
     * Ajouter ou retirer une offre des favoris (toggle)
     */
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'offer_id' => 'required|integer|exists:offers,id',
        ]);

        $userId = Auth::id();
        $offerId = $validated['offer_id'];

        // Vérifie si le favori existe déjà
        $favori = Favoris::where('user_id', $userId)
            ->where('offer_id', $offerId)
            ->first();

        if ($favori) {
            // Si existe → on le supprime
            $favori->delete();

            return response()->json([
                'success' => true,
                'in_favoris' => false,
                'message' => 'Offre retirée des favoris.',
                'type' => 'warning'
            ]);
        } else {
            // Sinon on l’ajoute
            Favoris::create([
                'user_id' => $userId,
                'offer_id' => $offerId,
                'date_ajout' => now(),
            ]);

            return response()->json([
                'success' => true,
                'in_favoris' => true,
                'message' => 'Offre ajoutée aux favoris.',
                'type' => 'success'
            ]);
        }
    }

    /**
     * Supprimer explicitement un favori
     */
    
}
