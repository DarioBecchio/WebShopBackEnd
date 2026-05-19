<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique()->comment('Master SKU (variant SKUs live on product_variants)');
            $table->string('slug')->unique();
            $table->foreignId('brand_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_line_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('skin_type_id')->nullable()->constrained()->nullOnDelete()
                  ->comment('Primary targeted skin type; multi-type via pivot if needed');
            $table->boolean('is_active')->default(true);
            $table->timestamp('launched_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['brand_id', 'is_active']);
            $table->index('category_id');
        });

        // Multilingual product names / descriptions
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 10)->comment('BCP-47: it, en, fr, de, ...');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('how_to_use')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('products');
    }
};
