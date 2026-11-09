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
    Schema::create('stock_movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
        $table->foreignId('product_batch_id')->constrained('product_batches')->restrictOnDelete();
        $table->foreignId('purchase_item_id')->nullable()->constrained('purchase_items')->nullOnDelete();
        $table->foreignId('order_item_id')->nullable()->constrained('order_items')->nullOnDelete();
        $table->foreignId('return_item_id')->nullable()->constrained('return_items')->nullOnDelete();
        $table->enum('movement_type', ['purchase', 'sale', 'return', 'damage', 'adjustment']);
        $table->enum('direction', ['in', 'out']);
        $table->unsignedInteger('quantity');
        $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
        $table->text('notes')->nullable();
        $table->timestamp('created_at')->nullable();

        $table->index('product_id');
        $table->index('movement_type');
        $table->index('created_at');
    });
}

public function down(): void
{
    Schema::dropIfExists('stock_movements');
}
};
