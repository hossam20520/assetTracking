<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Inventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id', true);

            $table->text('start_session_date')->nullable();
            $table->text('end_session_date')->nullable();
            $table->text('session_status')->nullable();

            $table->integer('room_id')->nullable()->index('item_id');
            $table->integer('user_id')->nullable()->index('user_id');

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
