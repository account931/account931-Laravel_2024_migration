<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('venue_name');
            $table->string('address');
            $table->boolean('active')->default(true);
            //hasMany foreign key in 2 steps
            $table->bigInteger('owner_id')->unsigned()->index()->nullable(); // this is working
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
			//$table->enum('location', ['UA', 'EU']);
            $table->timestamps();
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
        Schema::dropIfExists('venues');
    }
}
