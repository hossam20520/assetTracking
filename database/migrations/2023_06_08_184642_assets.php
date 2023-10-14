<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Assets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

  
 
     
       
 

        Schema::create('assets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
			$table->integer('id', true);
	 
            $table->string('ar_name', 192)->nullable();
            $table->date('purchase_date');
            $table->integer('client_id')->nullable()->index('client_id');
            $table->integer('category_id')->nullable()->index('category_id');
            $table->integer('group_id')->nullable()->index('group_id');
            $table->integer('location_id')->nullable()->index('location_id');
            $table->text('description')->nullable();
            $table->string('status', 192)->nullable();
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
