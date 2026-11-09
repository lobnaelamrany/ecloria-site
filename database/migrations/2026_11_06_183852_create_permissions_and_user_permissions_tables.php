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
    Schema::create('permissions', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();          // مثل: manage_products
        $table->string('label');                    // مثل: إدارة المنتجات
        $table->text('description')->nullable();
        $table->timestamps();
    });

    Schema::create('user_permissions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
        $table->foreignId('granted_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamp('created_at')->nullable();

        $table->unique(['user_id', 'permission_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('user_permissions');
    Schema::dropIfExists('permissions');
}
};
