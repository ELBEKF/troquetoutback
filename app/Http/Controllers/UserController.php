<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUser()
    {
        $data = Users::select(
        'id',
        'nom',
        'prenom',
        'ville',
        'code_postal',
        'telephone',
        'email',
        'password',
        'updated_at',
        'created_at',
        'role',
        )->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200); // code reponse 200 pour success
    }
public function getUserById($id)
    {

        $user = Users::find($id);

        if (!$user) {

            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur trouvé',
            'data' => $user,
        ], 200);
    }
    public function register(Request $request)
{
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

    return response()->json([
        'success' => true,
        'data' => $user,
        'message' => 'Inscription réussie, vous pouvez maintenant vous connecter.'
    ], 201);
}


//     public function profil()
// {
//     if (!Auth::check()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Veuillez vous connecter pour accéder à votre profil.'
//         ], 401);
//     }

//     $profil = Auth::user();

//     return response()->json([
//         'success' => true,
//         'data' => $profil
//     ]);
// }


//     public function modifProfil()
// {
//     if (!Auth::check()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Veuillez vous connecter pour modifier votre profil.'
//         ], 401);
//     }

//     $user = Auth::user();

//     return response()->json([
//         'success' => true,
//         'data' => $user
//     ]);
// }

//     public function updateProfil(Request $request)
// {
//     if (!Auth::check()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Veuillez vous connecter pour mettre à jour votre profil.'
//         ], 401);
//     }

//     $user = Auth::user();

//     $validated = $request->validate([
//         'nom' => 'required|string|max:255',
//         'prenom' => 'required|string|max:255',
//         'email' => 'required|email|unique:users,email,' . $user->id,
//         'telephone' => 'nullable|string|max:20',
//         'ville' => 'nullable|string|max:255',
//         'code_postal' => 'nullable|string|max:10',
//     ]);

//     $user->update($validated);

//     return response()->json([
//         'success' => true,
//         'data' => $user,
//         'message' => 'Profil mis à jour avec succès.'
//     ]);
// }
public function updateProfil(Request $requestParam, $id)
    {
        // on trouve l'utilisateur
        $user = Users::find($id);

        // on verifie s'il existe
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé',
            ], 404);
        }

        // on valide les données reçues
        $validatedData = $requestParam->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'telephone' => 'sometimes|string|max:20',
            'ville' => 'sometimes|string|max:50',
            'code_postal' => 'sometimes|string|max:20',
        ], [
            // Messages personnalisés
            'nom.string'        => 'Le nom doit être une chaîne de caractères.',
            'nom.max'           => 'Le nom ne peut pas dépasser 255 caractères.',
            'prenom.string'     => 'Le prénom doit être une chaîne de caractères.',
            'prenom.max'        => 'Le prénom ne peut pas dépasser 255 caractères.',
            'telephone.string'  => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.max'     => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
            'ville.string'      => 'La ville doit être une chaîne de caractères.',
            'ville.max'         => 'La ville ne peut pas dépasser 50 caractères.',
            'code_postal.string' => 'Le code postal doit être une chaîne de caractères.',
            'code_postal.max'   => 'Le code postal ne peut pas dépasser 20 caractères.',
        ]);

        // on met à jour l'utilisateur
        $user->update($validatedData);

        // on retourne la réponse
        return response()->json([
            'success' => true,
            'message' => 'Utilisateur trouvé et mis à jour avec succès',
            'data' => $user, // utilisateur mis à jour
        ], 200);
    }

}
