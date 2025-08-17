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
        Schema::table('cartridges', function (Blueprint $table) {
            $table->dropIndex('cartridges_barcode_index');
            $table->unique('barcode', 'cartridges_barcode_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cartridges', function (Blueprint $table) {
            $table->dropUnique('cartridges_barcode_unique');
            $table->index('barcode','cartridges_barcode_index');
        });
    }
};
