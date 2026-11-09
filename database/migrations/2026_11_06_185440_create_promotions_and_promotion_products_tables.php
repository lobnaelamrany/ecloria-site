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
    Schema::create('promotions', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->enum('discount_type', ['percentage', 'fixed']);
        $table->decimal('discount_value', 10, 2);
        $table->dateTime('starts_at');
        $table->dateTime('ends_at');
        $table->boolean('is_active')->default(true);
        $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
        $table->timestamps();

        $table->index(['is_active', 'starts_at', 'ends_at']);
    });

    Schema::create('promotion_products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('promotion_id')->constrained('promotions')->cascadeOnDelete();
        $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
        $table->timestamp('created_at')->nullable();

        $table->unique(['promotion_id', 'product_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('promotion_products');
    Schema::dropIfExists('promotions');
}
};
