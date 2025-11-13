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
        Schema::create('marches', function (Blueprint $table) {
            $table->id();
            $table->date('date');

            $table->foreignId('produit_id')
                ->constrained('produits')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('marche')->nullable();
            $table->string('monnaie', 3)->default('MGA');
            $table->string('source')->nullable();

            $table->decimal('prix', 12, 2);
            $table->integer('disponibilite')->nullable();

            $table->timestamps();

            $table->unique(['date','produit_id','marche']);
            $table->index(['produit_id','date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marches');
    }
};
