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
        Schema::create('cartridges', function (Blueprint $table) {
            $table->id();
            // $table->string('model', 50);
            $table->string('barcode', 10)->index()->nullable();
            $table->text('comment')->nullable();
            $table->boolean('working')->default(true);
            $table->timestamps();

            $table->foreignId('place_id')->index()->constrained('places');
            $table->foreignId('model_id')->index()->constrained('cartridge_models');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartridges');
    }
};
