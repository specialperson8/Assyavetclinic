<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('language_id');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->string('section_title');
            $table->text('title');
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
        Schema::dropIfExists('portfolio_sections');
    }
}
