<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    // 🔹 Récupérer toutes les offres
    public function getOffer()
    {
        $data = Offers::select(
            'id',
            'titre',
            'description',
            'sens',
            'type',
            'categorie',
            'etat',
            'prix',
            'caution',
            'localisation',
            'photo',
            'disponibilite',
            'statut',
            'user_id'
        )->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    // 🔹 Récupérer une offre par ID
    public function getOfferById($id)
    {
        $offer = Offers::find($id);

        if (!$offer) {
            return response()->json([
                'success' => false,
                'message' => 'Offre non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $offer
        ], 200);
    }

    // 🔹 Ajouter une nouvelle offre
    public function addOffer(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'sens' => 'required|in:offre,demande',
            'type' => 'required|in:don,pret,location',
            'categorie' => 'required|string|max:100',
            'etat' => 'required|in:neuf,bon,use',
            'prix' => 'required|numeric|min:0',
            'caution' => 'required|numeric|min:0',
            'localisation' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
            'disponibilite' => 'required|date',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        try {
            if ($request->hasFile('photo')) {
                $validatedData['photo'] = $request->file('photo')->store('photo_offers', 'public');
            }

            $offer = Offers::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Offre créée avec succès',
                'data' => $offer
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'offre',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔹 Mettre à jour une offre
    public function updateOffer(Request $request, $id)
    {
        $offer = Offers::find($id);

        if (!$offer) {
            return response()->json([
                'success' => false,
                'message' => 'Offre non trouvée'
            ], 404);
        }

        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'sens' => 'required|in:offre,demande',
            'type' => 'required|in:don,pret,location',
            'categorie' => 'required|string|max:100',
            'etat' => 'required|in:neuf,bon,use',
            'prix' => 'required|numeric|min:0',
            'caution' => 'required|numeric|min:0',
            'localisation' => 'required|string|max:255',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:2048',
            'disponibilite' => 'required|date',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        try {
            if ($request->hasFile('photo')) {
                $validatedData['photo'] = $request->file('photo')->store('photo_offers', 'public');
            }

            $offer->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Offre mise à jour avec succès',
                'data' => $offer
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 🔹 Supprimer une offre
    public function deleteOffer($id)
    {
        $offer = Offers::find($id);

        if (!$offer) {
            return response()->json([
                'success' => false,
                'message' => 'Offre non trouvée'
            ], 404);
        }

        try {
            $offer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Offre supprimée avec succès'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
