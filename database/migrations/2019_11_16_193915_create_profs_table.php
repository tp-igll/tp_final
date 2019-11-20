<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom')->collation('utf8_general_ci');
            $table->string('prenom')->collation('utf8_general_ci');
            $table->string('email')->collation('utf8_general_ci');
            $table->string('liste_grp')->collation('utf8_general_ci')->nullable();
            $table->string('liste_sect')->collation('utf8_general_ci')->nullable();
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
        Schema::dropIfExists('profs');
    }
}
