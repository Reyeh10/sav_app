<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('type_client', [
                'Particulier',
                'Gouvernement',
                'Para-public',
                'Privee'
            ])->after('name'); // adapte selon ta structure
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('type_client');
        });
    }
};

