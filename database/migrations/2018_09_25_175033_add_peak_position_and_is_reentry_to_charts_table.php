<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeakPositionAndIsReentryToChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charts', function (Blueprint $table) {
            $table->integer('peak_position')->after('periods_on_chart')->nullable();
            $table->tinyInteger('is_reentry')->after('peak_position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charts', function (Blueprint $table) {
            $table->dropColumn(['peak_position', 'is_reentry']);
        });
    }
}
