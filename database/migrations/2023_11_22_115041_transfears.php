<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transfears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transfears', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id', true);
            $table->integer('item_id')->nullable()->index('item_id');
            $table->integer('old_room_id')->nullable()->index('old_room_id');
            $table->integer('old_location_id')->nullable()->index('old_location_id');
            $table->integer('old_floor_id')->nullable()->index('old_floor_id');
            $table->integer('user_id')->nullable()->index('user_id');
            $table->integer('inventorie')->nullable()->index('inventorie');
            $table->date('date')->nullable();
			$table->timestamps(6);
			$table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
