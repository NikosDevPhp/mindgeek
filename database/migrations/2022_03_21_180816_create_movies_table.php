<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('feedId')->unique();
            $table->string('body', 10000);
            $table->string('cert')->nullable();
            $table->string('class')->nullable();
            $table->integer('duration')->nullable();
            $table->string('headline')->nullable();
            $table->date('lastUpdated')->nullable();
            $table->string('quote')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->string('reviewAuthor')->nullable();
            $table->string('skyGoId')->nullable();
            $table->string('skyGoUrl')->nullable();
            $table->string('sum')->nullable();
            $table->string('url')->nullable();
            $table->integer('year')->nullable();
            $table->string('viewingTitle')->nullable();
            $table->date('viewingStartDate')->nullable();
            $table->date('viewingEndDate')->nullable();
            $table->string('viewingWayToWatch')->nullable();
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
        Schema::dropIfExists('movies');
    }
};
