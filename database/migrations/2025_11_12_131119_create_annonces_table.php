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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();

            $table->enum('categorie', ['offre', 'demande']);

            $table->foreignId('produit_id')
                ->constrained('produits')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->decimal('quantite', 12, 2)->nullable();
            $table->decimal('prix_unitaire', 12, 2)->nullable();

            $table->string('commune')->nullable();
            $table->string('district')->nullable();
            $table->string('region')->nullable();

            $table->string('contact', 10)->nullable();

            $table->timestamps();

            $table->index(['categorie', 'produit_id', 'region']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
