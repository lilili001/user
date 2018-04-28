<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUserAddressTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__useraddress_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('useraddress_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['useraddress_id', 'locale']);
            $table->foreign('useraddress_id')->references('id')->on('user__useraddresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user__useraddress_translations', function (Blueprint $table) {
            $table->dropForeign(['useraddress_id']);
        });
        Schema::dropIfExists('user__useraddress_translations');
    }
}
