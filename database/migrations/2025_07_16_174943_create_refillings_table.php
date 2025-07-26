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
        Schema::create('refillings', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_dispatch')->index()->nullable();
            $table->timestamp('date_receipt')->index()->nullable();
            $table->boolean('completed')->default(false);
            $table->foreignId('cartridge_id')->index()->constrained('cartridges');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refillings');
    }
};
