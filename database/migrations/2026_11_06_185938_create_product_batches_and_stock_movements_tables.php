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
    Schema::create('product_batches', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
        $table->foreignId('purchase_item_id')->nullable()->constrained('purchase_items')->nullOnDelete();
        $table->string('batch_number')->nullable();
        $table->date('expiry_date')->nullable();
        $table->unsignedInteger('quantity_received');
        $table->unsignedInteger('quantity_remaining');
        $table->timestamp('received_at');
        $table->timestamps();

        $table->index(['product_id', 'expiry_date']);
    });
}

public function down(): void
{
    Schema::dropIfExists('product_batches');
}
};
