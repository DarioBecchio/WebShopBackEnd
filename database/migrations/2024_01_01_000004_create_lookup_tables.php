<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Skin types (normal, dry, oily, combination, sensitive, all)
        Schema::create('skin_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('label');
            $table->timestamps();
        });

        // Skin concerns (acne, aging, hyperpigmentation, redness, ...)
        Schema::create('skin_concerns', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->unique();
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Cosmetic finishes (matte, satin, dewy, glossy, natural, ...)
        Schema::create('finishes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('label');
            $table->timestamps();
        });

        // Shade families (nude, red, pink, berry, orange, brown, ...)
        Schema::create('shade_families', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('hex_swatch', 7)->nullable()->comment('Representative hex color, e.g. #C4886B');
            $table->timestamps();
        });

        // Individual shades (e.g. "Mocha Rose", "Classic Red", ...)
        Schema::create('shades', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hex_color', 7)->nullable()->comment('Hex color, e.g. #E8A0A0');
            $table->foreignId('shade_family_id')->constrained()->restrictOnDelete();
            $table->foreignId('finish_id')->nullable()->constrained('finishes')->nullOnDelete();
            $table->timestamps();
        });

        // Sizes / volumes (50ml, 100ml, 30g, ...)
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 8, 2);
            $table->string('unit', 16)->comment('ml, g, oz, fl_oz, piece, ...');
            $table->string('display_label', 32)->comment('Human-readable: "50 ml", "1.7 fl oz"');
            $table->timestamps();

            $table->unique(['amount', 'unit']);
        });

        // Marketing / regulatory claims (paraben-free, SPF 30, hypoallergenic, ...)
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->string('code', 64)->unique();
            $table->string('label');
            $table->string('category', 32)->nullable()->comment('e.g. ingredient, spf, skin_benefit, eco');
            $table->timestamps();
        });

        // Third-party certifications (COSMOS, Leaping Bunny, ECOCERT, ...)
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('name');
            $table->string('issuing_body')->nullable();
            $table->string('logo_url')->nullable();
            $table->timestamps();
        });

        // INCI ingredients (Aqua, Niacinamide, Retinol, ...)
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('inci_name')->unique()->comment('INCI standard name (uppercase)');
            $table->string('common_name')->nullable()->comment('Colloquial name: "Vitamin C"');
            $table->text('function_description')->nullable()->comment('Emollient, preservative, active, ...');
            $table->boolean('is_allergen')->default(false)->comment('EU regulated allergen');
            $table->boolean('is_endocrine_disruptor')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('certifications');
        Schema::dropIfExists('claims');
        Schema::dropIfExists('sizes');
        Schema::dropIfExists('shades');
        Schema::dropIfExists('shade_families');
        Schema::dropIfExists('finishes');
        Schema::dropIfExists('skin_concerns');
        Schema::dropIfExists('skin_types');
    }
};
