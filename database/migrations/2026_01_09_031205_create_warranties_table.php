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
        Schema::create('warranties', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->unique()
            ->constrained()->cascadeOnDelete();
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('max_mileage');
        $table->text('coverage');
        $table->enum('status', ['active', 'expired'])->default('active');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranties');
    }
};
