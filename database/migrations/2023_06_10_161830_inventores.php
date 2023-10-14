<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Inventores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('inventores', function (Blueprint $table) {
             $table->engine = 'InnoDB';
			 $table->integer( 'id'  ,  true);
			 $table->string('ar_name', 192)->nullable();      
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
        Schema::dropIfExists('inventores');
    }
}
