<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Each sellable unit: product × shade × size combination
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shade_id')->nullable()->constrained('shades')->nullOnDelete()
                  ->comment('Null for unshaded products (serums, sunscreens, ...)');
            $table->foreignId('size_id')->nullable()->constrained('sizes')->nullOnDelete();
            $table->string('sku')->unique();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('EUR')->comment('ISO 4217');
            $table->unsignedInteger('stock_qty')->default(0);
            $table->boolean('is_default')->default(false)
                  ->comment('Default variant shown on product page');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['product_id', 'is_default']);
            $table->unique(['product_id', 'shade_id', 'size_id'], 'unique_variant_combo');
        });

        // Images and videos per variant
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->string('type', 16)->comment('image, video, swatch');
            $table->string('url');
            $table->string('alt_text')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['variant_id', 'sort_order']);
        });

        // Packaging metadata per variant (material, eco, weight, origin)
        Schema::create('packaging', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->string('material_type', 64)->nullable()
                  ->comment('Glass, PET, PP, cardboard, ...');
            $table->boolean('is_recyclable')->default(false);
            $table->boolean('is_refillable')->default(false);
            $table->decimal('weight_grams', 8, 2)->nullable()
                  ->comment('Net weight of packaged unit');
            $table->string('country_of_origin', 2)->nullable()
                  ->comment('ISO 3166-1 alpha-2');
            $table->timestamps();

            $table->unique('variant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packaging');
        Schema::dropIfExists('media');
        Schema::dropIfExists('product_variants');
    }
};
