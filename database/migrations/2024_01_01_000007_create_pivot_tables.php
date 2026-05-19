<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // INCI ingredient list per variant, in order of concentration
        Schema::create('product_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->foreignId('ingredient_id')->constrained('ingredients')->restrictOnDelete();
            $table->unsignedSmallInteger('position')->comment('Order in the INCI list (1 = highest concentration)');
            $table->boolean('is_key_ingredient')->default(false)
                  ->comment('Highlighted as hero/key ingredient in marketing');
            $table->timestamps();

            $table->unique(['variant_id', 'ingredient_id']);
            $table->index(['variant_id', 'position']);
        });

        // Marketing and regulatory claims per product
        Schema::create('product_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('claim_id')->constrained()->restrictOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'claim_id']);
        });

        // Third-party certifications per product (with validity window)
        Schema::create('product_certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('certification_id')->constrained()->restrictOnDelete();
            $table->date('certified_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'certification_id']);
        });

        // Skin concerns addressed by a product
        Schema::create('product_skin_concerns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skin_concern_id')->constrained()->restrictOnDelete();
            $table->timestamps();

            $table->unique(['product_id', 'skin_concern_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_skin_concerns');
        Schema::dropIfExists('product_certifications');
        Schema::dropIfExists('product_claims');
        Schema::dropIfExists('product_ingredients');
    }
};
