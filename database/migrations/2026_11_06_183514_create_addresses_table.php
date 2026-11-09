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
    Schema::create('addresses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->string('title');                              // مثل: المنزل، العمل
        $table->string('full_name');
        $table->string('phone');
        $table->string('city');
        $table->string('neighborhood')->nullable();           // الحي
        $table->string('street_address');
        $table->string('postal_code')->nullable();
        $table->text('additional_info')->nullable();
        $table->boolean('is_default')->default(false);
        $table->timestamps();

        $table->index('user_id');
    });
}

public function down(): void
{
    Schema::dropIfExists('addresses');
}
};
