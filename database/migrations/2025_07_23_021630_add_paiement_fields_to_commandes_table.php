<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
{
    Schema::table('commandes', function (Blueprint $table) {
        if (!Schema::hasColumn('commandes', 'paiement_effectue')) {
            $table->boolean('paiement_effectue')->default(0);
        }

        if (!Schema::hasColumn('commandes', 'statut')) {
            $table->string('statut')->default('en cours');
        }
    });
}


    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('paiement_effectue');
            $table->dropColumn('statut');
            $table->dropForeign(['paiement_id']);
            $table->dropColumn('paiement_id');
        });
    }
};

