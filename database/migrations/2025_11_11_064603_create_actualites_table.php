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
        Schema::create('actualites', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();

            $table->text('contenu')->nullable();
            $table->string('image')->nullable();

            $table->enum('statut', ['brouillon','publie'])->default('publie');
            $table->timestamp('publie_le')->nullable();

            $table->boolean('ala_une')->default(false);
            $table->foreignId('auteur_id')->nullable()->constrained('users')->nullOnDelete();

            $table->index(['ala_une','publie_le']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actualites');
    }
};
