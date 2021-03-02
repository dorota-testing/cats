<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTableNewsCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::drop('news_category');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('news_category', function (Blueprint $table) {
            $table->increments('id');
			$table->string('category', 100);
            $table->string('url', 100); //column in the table
            $table->timestamps();
        });
    }
}
