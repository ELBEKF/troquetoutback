<?php


use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OffersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;


Route::get('/test', function () {
    return response()->json(['message' => 'OK']);
});
// Offers
Route::get('/allOffers', [OffersController::class, 'getOffer']);
Route::get('/offers/{id}', [OffersController::class, 'getOfferById']);
Route::post('/offers', [OffersController::class, 'addOffer']);
Route::put('/offers/{id}', [OffersController::class, 'updateOffer']);
Route::delete('/offers/{id}', [OffersController::class, 'deleteOffer']);

// Request
Route::get('/requests', [RequestController::class, 'index']); 
Route::post('/requests', [RequestController::class, 'store']); 
Route::get('/mes-demandes', [RequestController::class, 'mesDemandes']); 
Route::put('/requests/{id}', [RequestController::class, 'update']); 
Route::delete('/requests/{id}', [RequestController::class, 'destroy']);

// Messages
Route::get('/messages/recus', [MessagesController::class, 'receivedMessages'])->name('messages.received');
Route::post('/messages/send', [MessagesController::class, 'send'])->name('messages.send');

// User
Route::post('/register', [UserController::class, 'register']);
Route::get('/profil', [UserController::class, 'profil']);
Route::get('/profil/edit', [UserController::class, 'modifProfil']);
Route::put('/profil/update', [UserController::class, 'updateProfil']);
