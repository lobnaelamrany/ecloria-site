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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
        $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
        $table->string('sku')->unique();
        $table->string('name_fr');
        $table->string('name_en')->nullable();
        $table->string('name_de')->nullable();
        $table->string('slug')->unique();
        $table->text('description_fr')->nullable();
        $table->text('description_en')->nullable();
        $table->text('description_de')->nullable();
        $table->decimal('price', 10, 2);
        $table->unsignedInteger('stock_quantity')->default(0);
        $table->unsignedInteger('low_stock_threshold')->default(5);
        $table->string('image')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        $table->softDeletes();

        $table->index('category_id');
        $table->index('brand_id');
        $table->index('is_active');
    });
}

public function down(): void
{
    Schema::dropIfExists('products');
}
};
