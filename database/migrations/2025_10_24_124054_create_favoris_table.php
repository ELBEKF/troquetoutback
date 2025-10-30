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
        Schema::create('favoris', function (Blueprint $table) {
            $table->id(); // id primaire AUTO_INCREMENT

            $table->unsignedBigInteger('user_id');  // référence à l'utilisateur
            $table->unsignedBigInteger('offer_id'); // référence à l'offre
            $table->timestamp('date_ajout')->useCurrent(); // date d'ajout par défaut CURRENT_TIMESTAMP

            // Clés étrangères optionnelles
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('offer_id')->references('id')->on('reponses_offers')->onDelete('cascade');

            // Si tu veux suivre les mises à jour
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
