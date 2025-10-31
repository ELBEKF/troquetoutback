<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\AdminController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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

Route::middleware(['guest'])->group(
    function () {
        Route::post('/login', [AuthController::class, 'login']);
    }
);

// favoris
Route::get('/favoris', [FavorisController::class, 'index'])->name('favoris.index');
Route::post('/favoris/toggle', [FavorisController::class, 'toggle'])->name('favoris.toggle');
Route::delete('/favoris/{offerId}', [FavorisController::class, 'destroy'])->name('favoris.destroy');

// admin
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/user/{id}', [AdminController::class, 'getUserById'])->name('admin.user.show');
Route::put('/admin/user/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update');
Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
Route::delete('/admin/offer/{id}', [AdminController::class, 'deleteOffer'])->name('admin.offer.delete');