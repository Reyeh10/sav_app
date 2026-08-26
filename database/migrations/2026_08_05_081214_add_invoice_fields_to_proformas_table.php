<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajouter les champs de calcul du proforma.
     */
    public function up(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->decimal('discount_percent', 5, 2)
                ->default(0)
                ->after('proforma_price');

            $table->decimal('discount_amount', 15, 2)
                ->default(0)
                ->after('discount_percent');

            $table->string('invoice_type')
                ->default('with_tax')
                ->after('discount_amount');
        });
    }

    /**
     * Supprimer les champs en cas de rollback.
     */
    public function down(): void
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->dropColumn([
                'discount_percent',
                'discount_amount',
                'invoice_type',
            ]);
        });
    }
};
