<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function($table) {
             $table->increments('id')->unsigned();
             $table->string('title', 250);
             $table->integer('pages_count');
             $table->decimal('price', 5, 2);
             $table->text('description');
             $table->timestamps();
             $table->integer('author_id')->unsigned();
             $table->foreign('author_id')->references('id')->on('authors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
