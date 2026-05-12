<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->enum('type', [
                'complaint',  // reclamo
                'return',     // richiesta reso
                'info',       // informazioni
                'order',      // problema ordine
                'other',      // altro
            ])->default('other');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', [
                'new',         // nuovo, non letto
                'in_progress', // in gestione
                'resolved',    // risolto
            ])->default('new');
            $table->text('admin_reply')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};