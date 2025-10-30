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
       Schema::create('offers', function (Blueprint $table) {
    $table->id();
    $table->string('titre', 255);
    $table->text('description');
    $table->enum('sens', ['offre', 'demande']);
    $table->enum('type', ['don', 'pret', 'location']);
    $table->string('categorie', 100);
    $table->enum('etat', ['neuf', 'bon', 'use'])->default('bon');
    $table->decimal('prix', 6, 2);
    $table->decimal('caution', 6, 2);
    $table->string('localisation', 255);
    $table->string('photo', 255)->nullable();
    $table->date('disponibilite');
    $table->tinyInteger('statut')->default(1);
    $table->unsignedBigInteger('user_id')->nullable();
    $table->timestamps(); // créé created_at et updated_at automatiquement
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
