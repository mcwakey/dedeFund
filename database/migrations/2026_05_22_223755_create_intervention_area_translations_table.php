<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('intervention_area_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_area_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5)->index();
            $table->string('name');
            $table->string('slug');
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->timestamps();

            $table->unique(['locale', 'slug']);
            $table->unique(['intervention_area_id', 'locale'], 'iat_area_id_locale_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervention_area_translations');
    }
};
