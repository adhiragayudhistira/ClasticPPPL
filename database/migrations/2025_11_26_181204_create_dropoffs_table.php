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
    Schema::create('dropoffs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('transaction_code')->unique();

        $table->string('address');
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();
        $table->date('date');
        $table->string('time_slot'); // "08:00 - 10:00"

        // contoh jenis plastik per kolom (biar simpel kayak invoice kamu)
        $table->decimal('hdpe_weight', 5, 2)->default(0); // Kg
        $table->decimal('pvc_weight', 5, 2)->default(0);  // Kg

        $table->integer('points')->default(0);
        $table->string('status')->default('processed'); // processed, accepted, converted

        $table->timestamps();
    });
}
};
