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
    // orders: الطلبات
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_number')->unique();
        $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
        $table->enum('order_status', [
            'pending',
            'confirmed',
            'preparing',
            'ready',
            'out_for_delivery',
            'delivered',
            'collected',
            'cancelled',
        ])->default('pending');
        $table->enum('delivery_method', ['delivery', 'store_pickup']);
        $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();

        // Snapshots (لقطات من بيانات العميل وقت الطلب)
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->string('shipping_city');
        $table->string('shipping_address')->nullable();
        $table->string('shipping_postal_code')->nullable();

        // المبالغ
        $table->decimal('subtotal', 10, 2);
        $table->decimal('discount_amount', 10, 2)->default(0);
        $table->decimal('shipping_fee', 10, 2)->default(0);
        $table->decimal('total_amount', 10, 2);

        $table->text('customer_note')->nullable();

        // تواريخ الحالات
        $table->timestamp('confirmed_at')->nullable();
        $table->timestamp('delivered_at')->nullable();
        $table->timestamp('collected_at')->nullable();
        $table->timestamp('cancelled_at')->nullable();

        $table->timestamps();

        $table->index('order_status');
        $table->index('user_id');
    });

    // order_items: عناصر الطلب
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
        $table->foreignId('product_id')->constrained('products')->restrictOnDelete();

        // Snapshots (لقطات من بيانات المنتج وقت الطلب)
        $table->string('product_name');
        $table->string('product_sku');

        $table->decimal('unit_price', 10, 2);
        $table->unsignedInteger('quantity');
        $table->decimal('discount_amount', 10, 2)->default(0);
        $table->decimal('line_total', 10, 2);

        $table->timestamps();
    });

    // payments: الدفع (سجل واحد لكل طلب في v1)
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->unique()->constrained('orders')->cascadeOnDelete();
        $table->enum('payment_method', ['cash_on_delivery', 'payment_at_store']);
        $table->enum('payment_status', ['pending', 'paid', 'partially_refunded', 'refunded'])
              ->default('pending');
        $table->decimal('amount', 10, 2);
        $table->decimal('refunded_amount', 10, 2)->default(0);
        $table->timestamp('paid_at')->nullable();
        $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('payments');
    Schema::dropIfExists('order_items');
    Schema::dropIfExists('orders');
}
};
