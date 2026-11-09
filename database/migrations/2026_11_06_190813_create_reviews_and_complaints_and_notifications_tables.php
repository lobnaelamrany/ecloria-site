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
    // reviews: تقييمات المنتجات
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
        $table->foreignId('order_item_id')->unique()->constrained('order_items')->cascadeOnDelete();
        $table->unsignedTinyInteger('rating'); // 1-5
        $table->text('comment')->nullable();
        $table->boolean('is_visible')->default(true);
        $table->timestamps();

        $table->index(['product_id', 'is_visible']);
    });

    // complaints: الشكاوى
    Schema::create('complaints', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
        $table->string('subject');
        $table->text('message');
        $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])
              ->default('open');
        $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamp('resolved_at')->nullable();
        $table->timestamps();

        $table->index('status');
    });

    // notifications: الإشعارات
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->string('title');
        $table->text('message');
        $table->string('type');
        $table->timestamp('read_at')->nullable();
        $table->timestamp('created_at')->nullable();

        $table->index(['user_id', 'read_at']);
    });
}

public function down(): void
{
    Schema::dropIfExists('notifications');
    Schema::dropIfExists('complaints');
    Schema::dropIfExists('reviews');
}
};
