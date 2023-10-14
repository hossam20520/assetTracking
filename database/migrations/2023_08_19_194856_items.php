<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('ar_name', 192)->nullable();
            $table->integer('category_id')->nullable()->index('category_id');
            $table->integer('room_id')->nullable()->index('room_id');
            $table->string('status', 192)->nullable();
            $table->string('purchase_date', 300)->nullable();
            $table->string('last_inventory', 300)->nullable();


            $table->string('orical_number', 300)->nullable();
            $table->string('room_number', 300)->nullable();
            $table->integer('major_id')->nullable()->index('major_id');
            $table->integer('minor_id')->nullable()->index('minor_id');
            $table->integer('detaild_id')->nullable()->index('detaild_id');

            $table->string('uuid', 300)->nullable();
            $table->text('image')->nullable();
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
