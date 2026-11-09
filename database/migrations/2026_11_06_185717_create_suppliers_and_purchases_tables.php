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
    // suppliers
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('contact_person')->nullable();
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('city')->nullable();
        $table->text('notes')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        $table->softDeletes();
    });

    // purchases
    Schema::create('purchases', function (Blueprint $table) {
        $table->id();
        $table->string('purchase_number')->unique();
        $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
        $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
        $table->enum('purchase_status', ['draft', 'ordered', 'received', 'cancelled'])
              ->default('draft');
        $table->date('purchase_date');
        $table->timestamp('received_at')->nullable();
        $table->decimal('total_cost', 10, 2)->default(0);
        $table->text('notes')->nullable();
        $table->timestamps();

        $table->index('purchase_status');
        $table->index('supplier_id');
    });

    // purchase_items
    Schema::create('purchase_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('purchase_id')->constrained('purchases')->cascadeOnDelete();
        $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
        $table->unsignedInteger('quantity_ordered');
        $table->unsignedInteger('quantity_received')->default(0);
        $table->decimal('unit_cost', 10, 2);
        $table->decimal('line_total', 10, 2);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('purchase_items');
    Schema::dropIfExists('purchases');
    Schema::dropIfExists('suppliers');
}
};
