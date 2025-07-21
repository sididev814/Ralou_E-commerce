<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->decimal('prix', 8, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->string('image')->nullable();
            $table->unsignedBigInteger('categorie_produit_id');
            $table->timestamps();

            $table->foreign('categorie_produit_id')
                ->references('id')
                ->on('categorie_produits')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
