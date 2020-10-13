<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScenarioCheckpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scenario_checkpoints', function (Blueprint $table) {
            $table->unsignedBigInteger('scenario_id');
            $table->unsignedBigInteger('checkpoint_id');
            $table->unsignedTinyInteger('sort_position');
            $table->timestamps();

            $table->primary(['scenario_id', 'checkpoint_id']);

            $table->foreign('scenario_id')
                ->references('id')
                ->on('scenarios')
                ->onDelete('cascade');

            $table->foreign('checkpoint_id')
                ->references('id')
                ->on('checkpoints')
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
        Schema::dropIfExists('scenario_checkpoints');
    }
}
