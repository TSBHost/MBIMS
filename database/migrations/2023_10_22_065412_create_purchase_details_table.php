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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_id');
            $table->bigInteger('product_id');
            $table->float('purchase_price',8,2);
            $table->integer('quantity');
            $table->float('total_amount',8,2);
            $table->text('note')->nullable();
            $table->integer('warranty_info')->nullable();
            $table->bigInteger('creator');
            $table->bigInteger('editor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
