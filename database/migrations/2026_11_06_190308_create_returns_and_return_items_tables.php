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
    // returns: طلبات الإرجاع
    Schema::create('returns', function (Blueprint $table) {
        $table->id();
        $table->string('return_number')->unique();
        $table->foreignId('order_id')->constrained('orders')->restrictOnDelete();
        $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
        $table->enum('return_status', [
            'requested',
            'approved',
            'rejected',
            'received',
            'refunded',
            'cancelled',
        ])->default('requested');
        $table->text('reason');
        $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamp('reviewed_at')->nullable();
        $table->timestamp('received_at')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();

        $table->index('return_status');
        $table->index('order_id');
    });

    // return_items: عناصر الإرجاع
    Schema::create('return_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('return_id')->constrained('returns')->cascadeOnDelete();
        $table->foreignId('order_item_id')->constrained('order_items')->restrictOnDelete();
        $table->unsignedInteger('quantity');
        $table->enum('item_condition', ['unopened', 'opened', 'damaged', 'other']);
        $table->boolean('restockable')->default(false);
        $table->decimal('refund_amount', 10, 2)->default(0);
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('return_items');
    Schema::dropIfExists('returns');
}
};
