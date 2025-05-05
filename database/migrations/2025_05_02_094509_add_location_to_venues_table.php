<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationToVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venues', function (Blueprint $table) {
            //
			// Add 'location' as a spatial POINT column and make it nullable with a comment. Uses getter in model to return array of coordinates
			//Could also use 'json' column, when in SQL 5.7
            $table->point('location')->nullable()->after('owner_id')->comment('lon, lat'); //Stores lon, lat, in spatial format, save => 'location' => DB::raw("ST_GeomFromText('POINT($longitude $latitude)')")
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venues', function (Blueprint $table) {
            //
			$table->dropColumn('location');
        });
    }
}
