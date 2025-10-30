<?php

namespace App\Http\Controllers;

use App\Models\Request as RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    // Récupérer toutes les demandes
    public function index()
    {
        $data = RequestModel::select(
        'id',
        'user_id',
        'titre',
        'description',
        'type_demande',
        'date_besoin',
        'created_at',
		'updated_at',
        )->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    // Créer une nouvelle demande
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_demande' => 'required|string',
            'date_besoin' => 'required|date'
        ]);

        $demande = RequestModel::create([
            'user_id' => Auth::id(), // ou $request->user_id si pas d’auth
            ...$validated
        ]);

        return response()->json([
            'success' => true,
            'data' => $demande
        ], 201);
    }

    // Mettre à jour une demande
    public function update(Request $request, $id)
    {
        $demande = RequestModel::findOrFail($id);

        if ($demande->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $demande->update($request->only(['titre', 'description', 'type_demande', 'date_besoin']));

        return response()->json(['success' => true, 'data' => $demande]);
    }

    // Supprimer une demande
    public function destroy($id)
    {
        $demande = RequestModel::findOrFail($id);

        if ($demande->user_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $demande->delete();

        return response()->json(['success' => true]);
    }

    // Récupérer les demandes de l’utilisateur connecté
    public function mesDemandes()
    {
        $userId = Auth::id();

        $data = RequestModel::where('user_id', $userId)->get();

        return response()->json(['success' => true, 'data' => $data]);
    }
}
