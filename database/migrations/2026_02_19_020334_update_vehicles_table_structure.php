<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('vehicles', function (Blueprint $table) {

        // Nouveaux champs (SANS after)
        $table->enum('engine', ['Essence','Diesel','HEV','PHEV','Electrique'])->nullable();

        $table->enum('configuration', ['Basic','Medium Option','Full Option'])->nullable();

        $table->string('engine_number')->nullable();

        // Soft delete
        $table->softDeletes();
    });
}


    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {

           // $table->renameColumn('model_year', 'annee');

            $table->dropColumn(['engine', 'configuration', 'engine_number']);

            //$table->string('photo')->nullable();
            //$table->string('immatriculation')->nullable();

            $table->dropSoftDeletes();
        });
    }
};
