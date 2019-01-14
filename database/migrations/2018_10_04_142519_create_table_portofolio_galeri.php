<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePortofolioGaleri extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kti_portofolio_galeri', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('administrator_id')->nullable()->unsigned();
            $table->integer('portofolio_id')->nullable()->default(null)->unsigned();
            $table->text('picture');
            $table->string('flag')->default('N');
            $table->timestamps();
        });

        Schema::table('kti_portofolio_galeri', function($table) {
            $table->foreign('administrator_id')->references('id')->on('kti_administrator')->onDelete('set null');
            $table->foreign('portofolio_id')->references('id')->on('kti_portofolio')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kti_portofolio_galeri');
    }
}
