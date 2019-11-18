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
            $table->bigIncrements('id_etud');
            $table->string('nom')->collation('utf8_general_ci');
            $table->string('prenom')->collation('utf8_general_ci');
            $table->string('email')->nullable()->collation('utf8_general_ci');
            $table->date('date_naissance');
            $table->text('adresse')->collation('utf8_general_ci');
            $table->integer('numero');
            $table->string('matricule')->collation('utf8_general_ci');
            $table->integer('niv')->default('1');
            $table->integer('grp')->nullable();
            $table->char('sect',1)->nullable()->collation('utf8_general_ci');
            $table->timestamps();
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
