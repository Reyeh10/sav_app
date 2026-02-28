<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->enum('payment_type', [
                'Cash',
                'Bon de commande',
                'Echeance'
            ])->after('sold_price');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
    }
};

