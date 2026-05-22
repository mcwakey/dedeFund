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
        Schema::create('donation_intents', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('donation_method')->nullable();
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->decimal('amount', 14, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->text('message')->nullable();
            $table->string('status')->default('new')->index();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_intents');
    }
};
