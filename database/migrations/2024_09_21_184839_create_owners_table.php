<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('phone');
			$table->boolean('confirmed')->default(true);
			$table->string('location');  // i.e ['UA', 'EU'], not lon/lat
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
        Schema::dropIfExists('owners');
    }
}
