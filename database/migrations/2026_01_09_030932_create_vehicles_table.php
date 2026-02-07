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
        Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('vin')->unique();
        $table->string('plate_number')->nullable();
        $table->string('brand');
        $table->string('model');
        $table->string('color_exterior')->nullable();
        $table->string('color_interior')->nullable();
        $table->integer('year');
        $table->date('arrival_date')->nullable();
        $table->integer('mileage')->default(0);
        $table->enum('status', [
            'draft',
            'inspected',
            'approved',
            'rejected',
            'sold'
        ])->default('draft');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
