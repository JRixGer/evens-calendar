<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsCalendar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_calendar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_description')->nullable();
            $table->date('event_date')->nullable();
            $table->string('event_day')->nullable();
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
        Schema::table('events_calendar', function (Blueprint $table) {
            //
        });
    }
}
