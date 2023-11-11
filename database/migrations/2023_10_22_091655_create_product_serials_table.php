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
        Schema::create('product_serials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_id');
            $table->bigInteger('purchase_details_id');
            $table->bigInteger('product_id');
            $table->string('serial_number');
            $table->tinyInteger('is_sold')->default(0);
            $table->bigInteger('sale_id')->nullable();
            $table->bigInteger('sale_details_id')->nullable();
            $table->bigInteger('creator');
            $table->bigInteger('editor')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serials');
    }
};
