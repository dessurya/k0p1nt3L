<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kti_management', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('administrator_id')->nullable()->unsigned();
            $table->string('name');
            $table->string('position_id');
            $table->string('position_en');
            $table->text('picture');
            $table->string('flag')->default('N');
            $table->dateTime('publish_at')->nullable();
            $table->timestamps();
        });

        Schema::table('kti_management', function($table) {
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
        Schema::dropIfExists('kti_management');
    }
}
