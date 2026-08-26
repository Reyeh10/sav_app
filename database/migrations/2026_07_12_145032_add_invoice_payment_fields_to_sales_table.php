<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('invoice_status')
                ->default('En attente')
                ->after('payment_type');

            $table->decimal('paid_amount', 15, 2)
                ->default(0)
                ->after('invoice_status');

            $table->timestamp('paid_at')
                ->nullable()
                ->after('paid_amount');

            $table->timestamp('cancelled_at')
                ->nullable()
                ->after('paid_at');

            $table->foreignId('cancelled_by')
                ->nullable()
                ->after('cancelled_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['cancelled_by']);

            $table->dropColumn([
                'invoice_status',
                'paid_amount',
                'paid_at',
                'cancelled_at',
                'cancelled_by',
            ]);
        });
    }
};
