<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // id primaire AUTO_INCREMENT

            $table->unsignedBigInteger('sender_id');   // utilisateur qui envoie le message
            $table->unsignedBigInteger('receiver_id'); // utilisateur qui reçoit le message
            $table->unsignedBigInteger('offer_id');    // référence à l'offre concernée
            $table->text('message');                   // contenu du message
            $table->dateTime('date_sent');             // date d'envoi

            // Clés étrangères optionnelles
            // $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('offer_id')->references('id')->on('reponses_offers')->onDelete('cascade');

            // Timestamps Laravel
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
