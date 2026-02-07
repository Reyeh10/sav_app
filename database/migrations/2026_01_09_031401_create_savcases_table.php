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
        Schema::create('savcases', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
        $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
        $table->enum('type', [
            'warranty',
            'maintenance',
            'diagnostic',
            'other'
        ]);
        $table->text('description');
        $table->boolean('requires_proforma')->default(false);
        $table->enum('status', [
            'pending',
            'approved',
            'rejected',
            'resolved'
        ])->default('pending');
        $table->foreignId('approved_by')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savcases');
    }
};
