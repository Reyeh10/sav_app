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
        Schema::create('inspections', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
        $table->foreignId('inspector_id')
            ->constrained('users')->cascadeOnDelete();
        $table->text('mechanical_state');
        $table->text('body_state');
        $table->text('interior_state');
        $table->boolean('compliance');
        $table->enum('status', ['approved', 'rejected']);
        $table->string('report_path')->nullable();
        $table->dateTime('inspected_at');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
