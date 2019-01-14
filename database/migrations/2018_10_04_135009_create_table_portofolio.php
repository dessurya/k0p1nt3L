<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePortofolio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kti_portofolio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('administrator_id')->nullable()->unsigned();
            $table->string('name_id')->uniqid();
            $table->string('name_en')->uniqid();
            $table->text('content_id');
            $table->text('content_en');
            $table->text('project_id')->nullable();
            $table->text('project_en')->nullable();
            $table->text('picture_first');
            $table->text('picture_second');
            $table->string('slug');
            $table->string('flag')->default('N');
            $table->dateTime('publish_at')->nullable();
            $table->timestamps();
        });

        Schema::table('kti_portofolio', function($table) {
            $table->foreign('administrator_id')->references('id')->on('kti_administrator')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kti_portofolio');
    }
}
