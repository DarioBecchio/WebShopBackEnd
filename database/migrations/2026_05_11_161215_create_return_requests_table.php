<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('order_number');
            $table->enum('status', [
                'pending',   // in attesa di valutazione
                'approved',  // approvato
                'rejected',  // rifiutato
                'completed', // rimborso effettuato
            ])->default('pending');
            $table->enum('reason', [
                'damaged',     // prodotto danneggiato
                'wrong_item',  // articolo sbagliato
                'not_as_described', // non corrisponde alla descrizione
                'changed_mind', // cambiato idea
                'other',       // altro
            ]);
            $table->text('description');
            $table->text('admin_notes')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};