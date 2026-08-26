<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proformas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->restrictOnDelete();

            $table->foreignId('customer_id')
                ->constrained('customers')
                ->restrictOnDelete();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            /*
             * Vente créée après conversion.
             */
            $table->foreignId('sale_id')
                ->nullable()
                ->constrained('sales')
                ->nullOnDelete();

            $table->decimal('proforma_price', 15, 2);

            $table->string('type_client')->nullable();

            $table->string('payment_type')->nullable();

            /*
             * Brouillon
             * Validé
             * Converti
             * Annulé
             * Expiré
             */
            $table->string('status')->default('Validé');

            $table->dateTime('proforma_date')->nullable();

            $table->date('valid_until')->nullable();

            $table->dateTime('converted_at')->nullable();

            $table->foreignId('converted_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('cancelled_at')->nullable();

            $table->foreignId('cancelled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('proforma_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proformas');
    }
};
