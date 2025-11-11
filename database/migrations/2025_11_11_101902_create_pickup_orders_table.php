<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
{
    Schema::create('pickup_orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->text('address');
        $table->decimal('estimated_weight', 8, 2);
        $table->enum('status', ['pending', 'confirmed', 'on-the-way', 'completed'])->default('pending');
        $table->timestamps();
    });
}

   
    public function down(): void
    {
        Schema::dropIfExists('pickup_orders');
    }
};
