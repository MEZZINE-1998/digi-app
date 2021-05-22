<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCvIdTabloisir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loisires', function (Blueprint $table) {
            $table->integer('cv_id')->unsigned()->after('id');

            $table->foreign('cv_id')->references('id')->on('cvs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loisires', function (Blueprint $table) {
            $table->dropForeign(['cv_id']);
            $table->dropCulomn('cv_id');
        });
    }
}
