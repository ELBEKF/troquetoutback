<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class MessagesController extends Controller
{

    public function receivedMessages()
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Veuillez vous connecter pour accéder à vos messages.'
        ], 401);
    }

    $userId = Auth::id(); 

    $receivedMessages = Messages::where('to_user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    $sentMessages = Messages::where('from_user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'messages' => $receivedMessages,
        'sent' => $sentMessages
    ]);
}


    
    public function send(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vous devez être connecté pour envoyer un message.');
        }

        
        $validated = $request->validate([
            'to_user_id' => 'required|integer|exists:users,id',
            'offer_id'   => 'required|integer|exists:offers,id',
            'message'    => 'required|string|max:1000',
        ], [
            'message.required' => 'Le message ne peut pas être vide.'
        ]);

        try {
            
            $message = new Messages();
            $message->from_user_id = Auth::id();
            $message->to_user_id = $validated['to_user_id'];
            $message->offer_id = $validated['offer_id'];
            $message->content = $validated['message'];
            $message->save();

            return redirect('/messages/recus')->with('success', 'Message envoyé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi du message : ' . $e->getMessage());
        }
    }
}
