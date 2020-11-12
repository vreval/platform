<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scenario_id');
            $table->unsignedBigInteger('start_checkpoint_id');
            $table->unsignedBigInteger('start_form_id');
            $table->unsignedTinyInteger('position')->unique();
            $table->unsignedBigInteger('type_id');
            $table->timestamps();

            $table->foreign('scenario_id')
                ->references('id')
                ->on('scenarios')
                ->onDelete('cascade');

            $table->foreign('start_checkpoint_id')
                ->references('id')
                ->on('checkpoints')
                ->onDelete('cascade');

            $table->foreign('start_form_id')
                ->references('id')
                ->on('forms')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('task_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
