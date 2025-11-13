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
        Schema::create('flux_commercials', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['import', 'export']);
            $table->foreignId('produit_id')
                ->constrained('produits')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->year('annee');
            $table->decimal('quantite', 12, 2)->nullable();
            $table->decimal('valeur', 14, 2)->nullable();
            $table->timestamps();

            $table->unique(['type','produit_id','annee']);
            $table->index(['type','annee']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flux_commercials');
    }
};
