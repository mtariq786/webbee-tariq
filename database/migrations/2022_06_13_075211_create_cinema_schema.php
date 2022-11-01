<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        /*List of Films*/
        Schema::create('films',function ($table){
            $table->increments('id');
            $table->string('film_name');
            $table->timestamps();
        });


        /*Seats*/

        Schema::create('seats',function ($table){
            $table->increments('id');
            $table->enum('seat_type',['vip','couple','super_vip','other'])->defult('other');
            $table->timestamps();
        });

        /*Seats Pricing*/
        Schema::create('seats_pricing',function ($table){
            $table->increments('id');
            $table->decimal('price',2);
            $table->integer('seat_id')->unsigned();
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
        });

        /*Films Showrooms*/
        Schema::create('films_showrooms',function ($table){
            $table->increments('id');
            $table->string('showroom_name');
            $table->integer('film_id')->unsigned();
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->integer('seat_id')->unsigned();
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');
            $table->timestamps();
        });



        /*Films Time*/
        Schema::create('films_time',function ($table){
            $table->increments('id');
            $table->dateTime('start');
            $table->dateTime('end');
        });


        /*Film show rooms film Time*/

        Schema::create('booking',function ($table){
           $table->increments('id');
            $table->integer('showroom_id')->unsigned();
            $table->foreign('showroom_id')->references('id')->on('films_showrooms')->onDelete('cascade');
            $table->integer('films_time_id')->unsigned();
            $table->foreign('films_time_id')->references('id')->on('films_time')->onDelete('cascade');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
