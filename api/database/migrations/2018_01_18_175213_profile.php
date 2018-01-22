<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Profile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('email', 150)->unique();
            $table->string('phone', 11)->nullable();
            
            $table->timestamps();
        });

        Schema::create('profile_experience', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            
            $table->string('company', 100);
            $table->date('started_at');
            $table->date('ended_at')->nullable();
            $table->string('description', 1000);

            $table->foreign('profile_id')->references('id')->on('profile')->onDelete('cascade');
        });

        Schema::create('profile_knowlogment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned();

            $table->string('name', 50);
            $table->integer('level')->unsigned();

            $table->foreign('profile_id')->references('id')->on('profile')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profile_knowlogment');
        Schema::drop('profile_experience');
        Schema::drop('profile');
    }
}
