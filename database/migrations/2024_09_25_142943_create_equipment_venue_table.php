<?php
//Pivot table (Many to Many relations)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentVenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_venue', function (Blueprint $table) {
            //$table->bigIncrements('id');
            
			$table->unsignedBigInteger('equipment_id')->nullable()->index(); // this is working
			$table->unsignedBigInteger('venue_id')->nullable(); // this is working
			
			$table->primary(['equipment_id', 'venue_id']);
			
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
			
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_venue');
    }
}
