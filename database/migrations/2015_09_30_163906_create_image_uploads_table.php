<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');

            /**
             * Follow the format (192.168.1.1) an can be optional
             */
            $table->string('user_ip', 15)->nullable();
            $table->string('image_path')->nullable();

            /**
             * Follow the format (20150930134855****)
             * YYYY + MM + DD + hh + mm + ss + \Faker::asciify(****)
             */
            $table->string('token', 18)->unique();
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
        Schema::drop('image_uploads');
    }
}
