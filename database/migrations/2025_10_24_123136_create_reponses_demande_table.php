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
        Schema::create('reponses_demande', function (Blueprint $table) {
            $table->id(); // id primaire AUTO_INCREMENT

            $table->unsignedBigInteger('user_id'); // référence vers un utilisateur
            $table->string('titre', 255); // titre de la réponse
            $table->text('description'); // description ou contenu de la réponse
            $table->enum('type_demande', ['prêt', 'don', 'location']); // type de demande
            $table->date('date_besoin'); // date du besoin
            $table->timestamp('created_at')->useCurrent(); // valeur par défaut = CURRENT_TIMESTAMP

            // Si tu veux que Laravel gère aussi updated_at automatiquement :
            // $table->timestamps();

            // (Optionnel) Ajoute la contrainte de clé étrangère si la table users existe :
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reponses_demande');
    }
};
