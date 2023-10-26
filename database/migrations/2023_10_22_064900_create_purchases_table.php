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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id');
            $table->date('purchase_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('purchase_code')->nullable();
            $table->float('total_amount',8,2);
            $table->float('discount',8,2)->default(0);
            $table->float('payable_amount',8,2)->default(0);
            $table->float('paid_amount',8,2)->default(0);
            $table->float('due_amount',8,2)->default(0);
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
        Schema::dropIfExists('purchases');
    }
};
