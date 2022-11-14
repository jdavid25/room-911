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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->string('observation');
            $table->date('date');
            $table->time('time');
            $table->string('employee_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();
            $table->foreign('module_id')
                ->references('id')->on('modules');
            $table->foreign('status_id')
                ->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
