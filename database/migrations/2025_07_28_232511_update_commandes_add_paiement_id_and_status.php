<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            // Ajouter paiement_id si non existant
            if (!Schema::hasColumn('commandes', 'paiement_id')) {
                $table->unsignedBigInteger('paiement_id')->nullable()->after('user_id');
                $table->foreign('paiement_id')->references('id')->on('paiements')->onDelete('set null');
            }

            // Ajouter paiement_effectue si non existant
            if (!Schema::hasColumn('commandes', 'paiement_effectue')) {
                $table->boolean('paiement_effectue')->default(false)->after('paiement_id');
            }

            // Ajouter statut si non existant
            if (!Schema::hasColumn('commandes', 'statut')) {
                $table->string('statut')->default('en cours')->after('paiement_effectue');
            }
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'paiement_id')) {
                $table->dropForeign(['paiement_id']);
                $table->dropColumn('paiement_id');
            }
            if (Schema::hasColumn('commandes', 'paiement_effectue')) {
                $table->dropColumn('paiement_effectue');
            }
            if (Schema::hasColumn('commandes', 'statut')) {
                $table->dropColumn('statut');
            }
        });
    }
};

