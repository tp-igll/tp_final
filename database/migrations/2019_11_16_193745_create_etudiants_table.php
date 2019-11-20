<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom')->collation('utf8_general_ci');
            $table->string('prenom')->collation('utf8_general_ci');
            $table->string('email')->nullable()->collation('utf8_general_ci');
            $table->date('date_naissance');
            $table->text('adresse')->collation('utf8_general_ci');
            $table->string('numero');
            $table->string('matricule')->collation('utf8_general_ci');
            $table->string('niv');
            $table->integer('grp')->nullable();
            $table->string('sect')->nullable()->collation('utf8_general_ci');
            $table->timestamps(); //never take them off
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
}
