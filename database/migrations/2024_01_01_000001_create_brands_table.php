<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('country_code', 2)->nullable()->comment('ISO 3166-1 alpha-2');
            $table->text('description')->nullable();
            $table->string('website_url')->nullable();
            $table->boolean('is_cruelty_free')->default(false);
            $table->boolean('is_vegan')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
