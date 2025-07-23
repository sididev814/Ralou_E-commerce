<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->string('telephone');
            $table->decimal('montant', 10, 2);
            $table->string('operateur'); // OrangeMoney, Airtel, Moov, etc.
            $table->string('statut')->default('Réussi'); // ou Échoué
            $table->string('transaction_id')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};

