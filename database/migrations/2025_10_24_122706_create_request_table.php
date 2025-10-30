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
    Schema::create('requests', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->string('titre', 255);
        $table->text('description');
        $table->enum('type_demande', ['prêt', 'don', 'location']);
        $table->date('date_besoin');
        $table->timestamps(); // ← Remplace ton created_at actuel
        
        // Clé étrangère (décommenter si users existe)
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
