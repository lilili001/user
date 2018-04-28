<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUserRegionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__userregion_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('userregion_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['userregion_id', 'locale']);
            $table->foreign('userregion_id')->references('id')->on('user__userregions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user__userregion_translations', function (Blueprint $table) {
            $table->dropForeign(['userregion_id']);
        });
        Schema::dropIfExists('user__userregion_translations');
    }
}
