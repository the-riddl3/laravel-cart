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
        Schema::create('product_group_items', function (Blueprint $table) {
            $table->id('item_id');
            $table->foreignId('group_id')
                ->references('group_id')
                ->on('product_groups')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->references('product_id')
                ->on('products')
                ->onDelete('cascade');

            $table->index('group_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_group_items');
    }
};
