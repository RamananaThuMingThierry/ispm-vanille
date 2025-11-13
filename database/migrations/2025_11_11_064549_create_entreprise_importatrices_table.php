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
        Schema::create('entreprise_importatrices', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('raison_sociale');
            $table->string('pays')->nullable();
            $table->string('adresse')->nullable();
            $table->string('responsable')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone', 20)->nullable();
            $table->text('activite')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // Index utiles
            $table->index(['nom']);
            $table->index(['raison_sociale']);
            $table->index(['pays']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprise_importatrices');
    }
};
