<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('sales')
            ->where('invoice_status', 'En attente')
            ->update([
                'invoice_status' => 'Vendu',
            ]);

        DB::table('sales')
            ->where('invoice_status', 'Payée')
            ->update([
                'invoice_status' => 'Payé',
            ]);

        DB::table('sales')
            ->where('invoice_status', 'Annulée')
            ->update([
                'invoice_status' => 'Annulé',
            ]);

        DB::statement(
            "ALTER TABLE sales
             MODIFY invoice_status VARCHAR(255)
             NOT NULL DEFAULT 'Vendu'"
        );
    }

    public function down(): void
    {
        DB::statement(
            "ALTER TABLE sales
             MODIFY invoice_status VARCHAR(255)
             NOT NULL DEFAULT 'En attente'"
        );
    }
};
